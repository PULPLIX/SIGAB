<?php

namespace App\Notifications\Estudiantes;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarAgregarEstudiante extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($estudiante, $persona_id)
    {
        $persona = Persona::find($persona_id);

        $mensaje = $persona->nombre." ".$persona->apellido." ha agregado un estudiante.";
        $url = route('estudiante.show', $estudiante->persona_id);
        $this->dataSet = [
            'id' => $estudiante->persona_id,
            'persona_id' => $persona->persona_id,
            'nombre' => $persona->nombre." ".$persona->apellido,
            'imagen_perfil' => $persona->imagen_perfil,
            'informacion' => "ha agregado un estudiante.",
            'color' => 'verde',
            'icono' => '<i class="fas fa-user-plus"></i>',
            'modelo' => 'estudiante',
            'mensaje' => $mensaje,
            'url' => $url
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->dataSet;
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->dataSet);
    }
}
