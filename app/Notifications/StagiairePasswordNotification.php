<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StagiairePasswordNotification extends Notification
{
    use Queueable;

    private $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre mot de passe pour accéder à votre espace stagiaire')
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ',')
            ->line('Votre compte a été créé avec succès.')
            ->line('Voici votre mot de passe pour accéder à votre espace stagiaire :')
            ->line('**Mot de passe : ' . $this->password . '**')
            ->line('Veuillez le conserver en lieu sûr.')
            ->action('Accéder à votre espace', url('/login'))
            ->line('Merci d\'utiliser notre plateforme de gestion des stagiaires.');
    }
}
