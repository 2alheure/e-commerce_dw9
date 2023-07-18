<?php

namespace Controllers;

use App\Cart;
use App\Command;
use Models\CommandModel;
use Models\ProductModel;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController {
    static function pay() {
        // We check that user is connected
        if (!is_connected()) {
            add_flash('info', 'Veuillez vous connecter avant de passer une commande.');
            redirect('/login');
        }

        // Then we create the checkout in DB
        $command = CommandModel::create(
            user('id'),
            Command::LIVRAISON_POINT_RELAI,
            Command::PAYMENT_CB
        );

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
}
