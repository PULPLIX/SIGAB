<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $primaryKey = 'persona_id';
    public $incrementing = false;

    public function usuario()
    {
        return $this->hasOne('App\User');
    }
    public function estudiante()
    {
        return $this->hasOne('App\Estudiante', 'persona_id');
    }
    public function personal()
    {
        return $this->hasOne('App\Personal', 'persona_id');
    }
    public function listasAsistencias()
    {
        return $this->belongsToMany('App\ListaAsistencia', 'actividad_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($persona) {
                $persona->usuario()->delete();
        });
    }
}
