<?php

namespace Controllers;

use App\Cart;
use App\Config;
use App\Command;
use Stripe\Stripe;
use Models\CommandModel;
use Models\ProductModel;
use Stripe\Checkout\Session;

class PaymentController {
    static function pay() {
        // We check that user is connected
        if (!is_connected()) {
            add_flash('info', 'Veuillez vous connecter avant de passer une commande.');
            redirect('/login');
        }

        if (Cart::isEmpty()) {
            add_flash('notice', 'Votre panier est vide.');
            redirect('/cart');
        }

        // Then we create the checkout in DB
        $command = static::createCommand();

        // We create the Stripe checkout
        Stripe::setApiKey(env('STRIPE_PRIVATE_KEY'));

        $line_items = [];
        $panier = Cart::getDetails();

        foreach ($panier['cart'] as $ligne) {
            $ligne_pour_stripe = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        // Optionnel
                        'name' => $ligne['product']->nom,
                        'images' => [
                            asset('img/products/' . $ligne['product']->image)
                        ] // Liens ABSOLUS
                    ],
                    'unit_amount' => $ligne['product']->prix * 100 // Prix en centimes
                ],
                'quantity' => $ligne['quantity'],
            ];

            $line_items[] = $ligne_pour_stripe;
        }

        $checkout = Session::create([
            'mode' => 'payment',
            'success_url' => url('/pay/success?token=' . $command->token), // Liens ABSOLUS (http://...)
            'cancel_url' => url('/pay/cancel'), // Liens ABSOLUS (http://...)
            'line_items' => $line_items
        ]);

        redirect($checkout->url);
    }

    static function paypal() {
        // We check that user is connected
        if (!is_connected()) {
            add_flash('info', 'Veuillez vous connecter avant de passer une commande.');
            redirect('/login');
        }

        if (Cart::isEmpty()) {
            add_flash('notice', 'Votre panier est vide.');
            redirect('/cart');
        }

        // Then we create the checkout in DB
        static::createCommand();

        $total = Cart::getDetails()['total'];
        Cart::empty();

        redirect('https://paypal.me/' . Config::USER_PAYPAL . '/' . $total);
    }

    static function payOther() {
        // We check that user is connected
        if (!is_connected()) {
            add_flash('info', 'Veuillez vous connecter avant de passer une commande.');
            redirect('/login');
        }

        if (Cart::isEmpty()) {
            add_flash('notice', 'Votre panier est vide.');
            redirect('/cart');
        }

        // Then we create the checkout in DB
        $command = static::createCommand();

        switch ($_SESSION['order']['mode_paiement_id']) {
            case Command::PAYMENT_ESPECES:
                $instructions =
                    'Rendez-vous au comptoir de notre magasin, situé ' .
                    '<b>55, rue du dromadaire - Montpellier</b> ' .
                    'pour régler par espèces.';
                break;

            case Command::PAYMENT_VIREMENT:
                $instructions =
                    'Faites-nous un virement à l\'IBAN suivant : ' .
                    '<b>FR 1234 5678 9101 1121 31</b>. ' .
                    'Indiquez la référence "' . $command->token . '" dans le motif du virement.';
                break;

            case Command::PAYMENT_CHEQUE:
                $instructions =
                    'Faites-nous parvenir votre chèque à l\'adresse ' .
                    '<b>55, rue du dromadaire - Montpellier</b>. ' .
                    'Celui-ci doit être libellé à l\'ordre de "La super boutique".';
                break;
        }

        Cart::empty();

        include view('cart/pay');
    }

    static function success() {
        if (empty($_GET['token'])) {
            error404();
        }

        CommandModel::payed($_GET['token']);

        $panier = Cart::getDetails();

        foreach ($panier['cart'] as $ligne) {
            $p = $ligne['product'];
            ProductModel::update(
                $p->id,
                $p->nom,
                $p->stock - $ligne['quantity'], // We decrement the product stock
                $p->description,
                $p->prix,
                $p->tva_id,
                $p->image
            );
        }

        Cart::empty();

        add_flash('success', 'Nous vous remercions pour votre achat !');
        add_flash('info', 'Votre commande a été payée avec succès. Elle vous sera expédiée au plus vite.');

        redirect('/');
    }

    static function cancel() {
        add_flash('info', 'Votre paiement a été annulé. Vous n\'avez pas été débité.');
        redirect('/cart');
    }

    private static function createCommand(): object {
        return CommandModel::create(
            user('id'),
            $_SESSION['order']['mode_livraison_id'],
            $_SESSION['order']['mode_paiement_id'],
            $_SESSION['order']['adresse_livraison'],
            $_SESSION['order']['adresse_facturation'],
        );
    }
}
