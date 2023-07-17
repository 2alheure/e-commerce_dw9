<?php

namespace Controllers;

use App\Config;
use App\Mail;

class ContactController {
    static function displayContact() {
        include view('static/contact');
    }

    static function handleContact() {
        if (
            empty($_POST['email'])
            || !check_email($_POST['email'])
            || empty($_POST['message'])
            || empty($_POST['subject'])
        ) {
            add_flash('error', 'Veuillez correctement saisir le formulaire.');
        } else {
            (new Mail())
                ->to(Config::MAIL_CONTACT)
                ->replyTo($_POST['email'])
                ->subject($_POST['subject'])
                ->text($_POST['message'])
                ->send();

                add_flash('success', 'Votre demande a été reçue.');
        }

        redirect('/contact');
    }
}
