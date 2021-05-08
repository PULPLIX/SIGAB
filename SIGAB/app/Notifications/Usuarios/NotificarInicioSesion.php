<?php

namespace App\Notifications\Usuarios;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;
use App\User;

class NotificarInicioSesion extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($usuario, $persona_id)
    {
        $this->persona = Persona::find($persona_id);
        $this->usuario = $usuario;
        $this->persona_id = $persona_id;
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha iniciado sesión.";
        return [
            'id' => $this->usuario->persona_id,
            'modelo' => 'usuario',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha iniciado sesión.";
        return new BroadcastMessage([
            'id' => $this->usuario->persona_id,
            'modelo' => 'usuario',
            'mensaje' => $mensaje
        ]);
    }
}
