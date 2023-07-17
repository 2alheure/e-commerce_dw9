<?php

namespace Controllers;

use App\FlashSession;
use Models\UserModel;

class AuthController {
    static function displayLoginForm() {
        include view('auth/login');
    }

    static function processLoginForm() {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            add_flash('error', 'Les deux champs sont requis.');
            redirect('/login');
        }

        $user = UserModel::getByEmail($_POST['login']);

        if (
            $user === false // Wrong login
            || !password_verify($_POST['password'], $user->password) // Wrong password
        ) {
            add_flash('error', 'Identifiants invalides.');
            redirect('/login');
        }

        add_flash('success', 'Vous êtes à présent connecté.');
        $_SESSION['user'] = $user;

        redirect('/home');
    }

    static function logout() {
        // We don't "destroy" the session as we want to keep the flashes
        // But we unset the user
        unset($_SESSION['user']);

        add_flash('success', 'Vous êtes à présent déconnecté.');
        redirect('/home');
    }

    static function displayRegisterForm() {
        include view('auth/register');
    }

    static function handleRegisterForm() {
        if (
            empty($_POST['email'])
            || !check_email($_POST['email'])
        ) {
            add_flash('error', 'L\'email est obligatoire et doit être valide.');
        }

        if (
            empty($_POST['password'])
            || !check_password($_POST['password'])
        ) {
            add_flash('error', 'Le mot de passe n\'a pas le bon format ou est manquant.');
        }

        if (
            empty($_POST['confirm'])
            || ($_POST['password'] ?? '') !== $_POST['confirm']
        ) {
            add_flash('error', 'Le mot de passe et sa confirmation ne correspondent pas.');
        }

        if (empty($_POST['cgu'])) {
            add_flash('error', 'Vous <b>DEVEZ</b> accepter nos CGU.');
        }

        if (!empty(FlashSession::getType('error'))) {
            // J'ai eu une erreur
            redirect('/register');
        }

        if (empty(UserModel::getByEmail($_POST['email']))) {
            // Le compte n'existe pas déjà
            UserModel::add(
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_BCRYPT)
            );
        }

        add_flash('success', 'Votre compte a bien été créé. Vous allez recevoir un email de confirmation.');
        redirect('/login');
    }

    static function delete() {
    }

    static function displayProfile() {
        include view('auth/profile');
    }
}
