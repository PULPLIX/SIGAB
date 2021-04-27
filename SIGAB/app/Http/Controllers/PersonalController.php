<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; //para acceder a la imagen y luego borrarla
use App\Persona;
use App\Personal;
use App\Idioma;
use App\Participacion;



class PersonalController extends Controller
{



    //Devuevle el listado del personal ordenados por su apellido.
    public function index()
    {

        // Array que devuelve los items que se cargan por página
        $paginaciones = [5, 10, 25, 50];
        //Obtiene del request los items que se quieren recuperar por página y si el atributo no viene en el
        //request se setea por defecto en 25 por página
        $itemsPagina = request('itemsPagina', 25);
        //Se recibe del request con el valor de nombre,apellido o cédula, si dicho valor no está seteado se pone en NULL
        $filtro = request('filtro', NULL);
        if (!is_null($filtro)) {
            $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id') //Inner join de personal con personas
                ->where('personas.persona_id', 'like', '%' . $filtro . '%') // Filtro para buscar por nombre de persona
                ->orWhere('personal.cargo', 'like', '%' . $filtro . '%') // Filtro para buscar el cargo del personal
                ->orWhereRaw("concat(nombre, ' ', apellido) like '%" . $filtro . "%'") //Filtro para buscar por nombre completo
                ->orderBy('personas.apellido', 'asc')
                ->paginate($itemsPagina); //Paginación de los resultados según el atributo seteado en el Request
        } else { //Si no se setea el filtro se devuelve un listado del personal
            $personal = Personal::join('personas', 'personal.persona_id', '=', 'personas.persona_id') //Inner join de personal con personas
                ->orderBy('personas.apellido', 'asc') // Ordena por medio del apellido de manera ascendente
                ->paginate($itemsPagina);; //Paginación de los resultados según el atributo seteado en el Request
        }

        //se devuelve la vista con los atributos de paginación del personal
        return view('control_personal.listado', [
            'personal' => $personal, // Listado de personal.
            'paginaciones' => $paginaciones, // Listado de items de paginaciones.
            'itemsPagina' => $itemsPagina, // Item que se desean por página.
            'filtro' => $filtro // Valor del filtro que se haya hecho para mantenerlo en la página
        ]);
    }

    // ===========================================================================================
    // Método para redireccionar al usuario a la vista de registro de personal
    //============================================================================================
    public function create()
    {
        return view('control_personal.registrar');
    }


    // ===========================================================================================
    // Método que guarda un personal en la BD
    //============================================================================================
    public function store(Request $request)
    {
        try { //se utiliza un try-catch para evitar el redireccionamiento a página default de error de Laravel


            $persona = new Persona(); //Se crea una nueva instacia de Persona
            $personal = new Personal(); //Se crea una nueva instacia de estudiante
            $participacion = new Participacion(); //Se crea una nueva instacia de estudiante

            // Se le establece la cédula a cada uno de los objetos para que en el método generalizado realice un guardado del registro y no un actualizar.
            //SI NO SE PONE LA CÉDULA EL MÉTODO GENERAL LO TOMA COMO ACTUALIZACIÓN.
            $personal->persona_id = $request->persona_id;
            $persona->persona_id = $request->persona_id;


            $this->guardarPersonal($persona, $personal, $request); //Se llama al método genérico para guardar un personal

            //Antes de guardar las participaciones se crea un registro de participaciones en la base de datos para luego ser actualizadas
            $participacion->persona_id = $request->persona_id;
            $participacion->save();


            $this->guardarParticipaciones($personal, $request); //Se actualizan las participaciones con los datos que vengan en el request.
            $this->guardarIdiomas($request); //Se guarda la lista de idiomas

            return Redirect::back()
                ->with('mensaje', '¡El registro ha sido exitoso!') //Retorna mensaje de exito con el response a la vista despues de registrar el objeto
                ->with('persona_registrada', $persona) //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos
                ->with('personal_registrado', $personal); //Retorna un objeto en el response con los atributos especificos que se acaban de ingresar en la base de datos

        } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
            return Redirect::back() //se redirecciona a la pagina de registro personal
                ->with('error', "El registro ingresado con la cédula  " . "$request->cedula" . " ya existe")  //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto           
                ->with('persona_no_insertada', $persona) //Retorna un objeto en el response con los atributos especificos que se habian digitados anteriormente
                ->with('personal_no_insertado', $personal); //Retorna un objeto en el response con los atributos especificos que se habian digitados anteriormente 
        }
    }

    // ===========================================================================================
    // Método que muestra la información detallada de un personal
    //============================================================================================
    public function show($id_personal)
    {
        //Busca en la base de datos al personal con la cédula indicada y obtiene también las participaciones asociadas a él.
        $personal = Personal::join('participaciones', 'personal.persona_id', '=', 'participaciones.persona_id')
            ->where('personal.persona_id', '=', $id_personal)
            ->first();

        //Se optiene un arreglo con los idiomas específicos de la persona.
        $idiomas = Idioma::where('persona_id', '=', $id_personal)->get();

        return view('control_personal.detalle', [
            'personal' => $personal,
            'idiomas' => $idiomas
        ]);
    }


    // ===========================================================================================
    // Método para actualizar los datos de un personal
    //============================================================================================
    public function update($id_personal, Request $request)
    {
        //Se crean instancias de persona y personal para crear inicializar los atributos de cada objeto
        $persona = new Persona();
        $personal = new Personal();

        // Se busca en la BD la persona que concuerde con el id que viene en el request
        $persona = Persona::find($id_personal);   //Se obtiene el personal que contiene ese ID

        // Se busca en la BD el personal que concuerde con el ID y se adjunta el registro de participaciones que tenga
        $personal = Personal::join('participaciones', 'personal.persona_id', '=', 'participaciones.persona_id')
            ->where('personal.persona_id', '=', $id_personal)
            ->first();

        $this->guardarPersonal($persona, $personal, $request); //Se llama al método genérico para guardar un personal
        $this->guardarParticipaciones($personal, $request); //Se llama al método genérico para guardar las participaciones

        Idioma::where('persona_id', $id_personal)->delete(); // Antes de guardar los idiommas de la persona, se eliminan todos los registros de idomas referentes a esa persona para que sea posible actualizarlo
        $this->guardarIdiomas($request); //Se llama al método genérico para guardar idiomas

        // Llamado al método que actualiza la foto de perfil
        $this->update_avatar($request, $personal);

        //Se retorna el detalle del personal ya modificado
        return redirect("/personal/detalle/{$personal->persona_id}");
    }


    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~
    // Métodos privados de ÚNICO uso dentro del controller
    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~

    // ===========================================================================================
    // Métodos para actualizar la foto del perfil de un personal
    //============================================================================================
    private function update_avatar($request, $personal)
    {
        //En caso de que se haya subido alguna foto con el request se procede a guardarlo en el repositorio de imagenes de perfil
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar'); // Se obtiene el objeto que viene en el request y se guarda dentro de una variable
            $archivo = time() . '.' . $avatar->getClientOriginalExtension(); // Se toma la hora y la extensión del archivo que se subió (.jpg,png,etc..)
            Image::make($avatar)->resize(500, 640)->save(public_path('/img/fotos/' . $archivo)); // Se utiliza la herramienta de Image para que todas las imágenes se guarden en el mismo formato

            if ($personal->persona->imagen_perfil != "default.jpg") // En caso de que *NO* se haya establecido una imagen por defecto
                File::delete(public_path('/img/fotos/' . $personal->persona->imagen_perfil)); //Elimina la foto anterior para que no queden archivos "basura"

            $personal->persona->imagen_perfil = $archivo; //Se le setea a la persona el nombre de la imagen de perfil con el formato especificado anteriormente (fecha.extension)
            $personal->persona->save(); //Se guarda el atributo en la BD
        }
    }

    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~
    // MÉTODOS GENÉRICOS DE ACTUALIZAR Y GUARDAR
    // ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~ ° ~

    //¡¡¡¡ NOTA IMPORTANTE !!!
    // Para que los métodos de guardado o actualizados genéricos funcionen, el request debe de mantener
    // siempre los mismos nombres que en la base de datos.



    // ===========================================================================================
    // Métodos genérico que toma los datos del request y *guarda* o *actualiza* un personal
    //============================================================================================
    private function guardarPersonal(&$persona, &$personal, $request)
    {
        //se setean los atributos del objeto
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->telefono_fijo = $request->telefono_fijo;
        $persona->telefono_celular = $request->telefono_celular;
        $persona->correo_personal = $request->correo_personal;
        $persona->correo_institucional = $request->correo_institucional;
        $persona->estado_civil = $request->estado_civil;
        $persona->direccion_residencia = $request->direccion_residencia;
        $persona->genero = $request->genero;
        
        //se setean los atributos del objeto tipo personal
        $personal->grado_academico = $request->grado_academico;
        $personal->cargo = $request->cargo;
        $personal->tipo_nombramiento = $request->tipo_nombramiento;
        $personal->tipo_puesto_1 = $request->tipo_puesto_1;
        $personal->tipo_puesto_2 = $request->tipo_puesto_2;
        $personal->jornada = $request->jornada;
        $personal->lugar_trabajo_externo = $request->trabajo_externo;
        $personal->anio_propiedad = $request->anio_propiedad;
        $personal->experiencia_profesional = $request->experiencia_profesional;
        $personal->experiencia_academica = $request->experiencia_academica;
        $personal->regimen_administrativo = $request->regimen_administrativo;
        $personal->regimen_docente = $request->regimen_docente;
        $personal->area_especializacion_1 = $request->area_especializacion_1;
        $personal->area_especializacion_2 = $request->area_especializacion_2;

        $persona->save(); //se guarda el objeto en la base de datos
        $personal->save();
    }

    // ==============================================================================================================
    // Métodos genérico que toma los datos del request y *guarda* o *actualiza* las participaciones de un personal
    //===============================================================================================================
    private function guardarParticipaciones(&$personal, $request)
    {
        //Se establecen los atributos del objeto participación según los datos que vengan del request.
        $personal->participacion->capacitacion_didactica =  $request->capacitacion_didactica;
        $personal->participacion->publicaciones =  $request->publicaciones;
        $personal->participacion->cursos_impartidos =  $request->cursos_impartidos;
        $personal->participacion->miembro_comisiones =  $request->miembro_comisiones;
        $personal->participacion->miembro_prueba_grado =  $request->miembro_prueba_grado;
        $personal->participacion->evaluador_defensa_publica =  $request->evaluador_defensa_publica;
        $personal->participacion->evaluacion_interna_ppaa =  $request->evaluacion_interna_ppaa;
        $personal->participacion->evaluacion_externa_ppaa =  $request->evaluacion_externa_ppaa;
        $personal->participacion->reconocimientos =  $request->reconocimientos;
        $personal->participacion->save(); // Se guarda el objeto participación en la base de datos
    }

    // ==============================================================================================================
    // Métodos genérico que toma los datos del request y *guarda* o *actualiza* la lista de idiomas de un personal
    //===============================================================================================================
    private function guardarIdiomas($request)
    {
        if (!is_null($request->idiomasJSON)) {
            $idiomas =  json_decode($request->idiomasJSON); // Se toma el arreglo que viene en el array en formato JSON y se transforma a código PHP
            foreach ($idiomas as &$idoma) { // Por cada uno de los idiomas que esté en el arreglo se realizan las siguientes opciones:
                $idiomaP =  new Idioma(); // Se crea una nueva instancia del objeto idioma
                $idiomaP->persona_id =  $request->persona_id; // Se le esteblece la cédula de la persona al objeto idioma
                $idiomaP->nombre =  $idoma; // Se establece el nombre del idioma
                $idiomaP->save(); // Se guarda el idioma en la BD
            }
        }
    }


    // ==============================================================================================================
    // Método que busca el personal por su ID para probar si esta registrado
    //===============================================================================================================

    public function edit($id_personal)
    {
        $personal = Personal::find($id_personal); //se busca la persona con el id del personal requerido
        if ($personal == null) {
            return response("No existe", 404); //si no lo encuentra devuelve mensaje de error
        } else {
            return response()->json($personal->persona, 200); //si hay un personal registrado con ese id lo retorna
        }
    }
}
