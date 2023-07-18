<?php

namespace Controllers;

use App\Cart;
use App\Command;
use App\FlashSession;
use Models\CommandModel;
use Models\UserModel;

class CommandController {
    static function displayOrderForm() {
        // We check that user is connected
        if (!is_connected()) {
            add_flash('info', 'Veuillez vous connecter avant de passer une commande.');
            redirect('/login');
        }

        if (Cart::isEmpty()) {
            add_flash('notice', 'Votre panier est vide.');
            redirect('/cart');
        }

        $modes_livraison = CommandModel::getAllMoyensLivraison();
        $moyens_paiement = CommandModel::getAllMoyensPaiement();

        include view('cart/order');
    }

    static function handleOrderForm() {
        // We check that user is connected
        if (!is_connected()) {
            add_flash('info', 'Veuillez vous connecter avant de passer une commande.');
            redirect('/login');
        }


        if (Cart::isEmpty()) {
            add_flash('notice', 'Votre panier est vide.');
            redirect('/cart');
        }

        if (
            empty($_POST['prenom'])
            || empty($_POST['nom'])
            || empty($_POST['tel'])
            || empty($_POST['adresse_livraison'])
            || empty($_POST['adresse_facturation'])
            || empty($_POST['mode_paiement_id'])
            || empty($_POST['mode_livraison_id'])
        ) {
            add_flash('error', 'Tous les champs sont requis.');
        }

        if (
            !preg_match('#[\d\+ \-\.]+#', $_POST['tel'])
        ) {
            add_flash('error', 'Le numéro de téléphone doit être valide.');
        }

        if (
            empty(CommandModel::getOneMoyenLivraison($_POST['mode_livraison_id']))
        ) {
            add_flash('error', 'Le moyen de livraison doit être valide.');
        }

        switch ($_POST['mode_paiement_id']) {
            case Command::PAYMENT_CB:
                $url = '/pay/cb';
                break;

            case Command::PAYMENT_PAYPAL:
                $url = '/pay/paypal';
                break;

            case Command::PAYMENT_CHEQUE:
            case Command::PAYMENT_ESPECES:
            case Command::PAYMENT_VIREMENT:
                $url = '/pay/other';
                break;

            default:
                add_flash('error', 'Le moyen de paiement doit être valide.');
        }

        if (!empty(FlashSession::getType('error'))) {
            // There is at least one error
            redirect('/order');
        }

        $_SESSION['user'] = UserModel::update(
            user('id'),
            user('email'),
            user('password'),
            user('image'),
            $_POST['tel'],
            $_POST['prenom'],
            $_POST['nom']
        );

        $_SESSION['order'] = [
            'adresse_livraison' => $_POST['adresse_livraison'],
            'adresse_facturation' => $_POST['adresse_facturation'],
            'mode_paiement_id' => $_POST['mode_paiement_id'],
            'mode_livraison_id' => $_POST['mode_livraison_id'],
        ];

        redirect($url);
    }
}
