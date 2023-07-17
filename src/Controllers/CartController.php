<?php

namespace Controllers;

use App\Cart;
use Models\ProductModel;

class CartController {
    static function add() {
        if (
            empty($_GET['id'])
            || empty($produit = ProductModel::getOne($_GET['id']))
        ) {
            error404();
        }

        if (
            empty($_POST['qtte'])
            || !is_numeric($_POST['qtte'])
        ) {
            add_flash('error', 'La quantité est incorrecte.');
        } else {
            Cart::add($produit, $_POST['qtte']);
        }

        redirect('/products/list');
    }

    static function remove() {
        if (
            empty($_GET['id'])
            || empty($produit = ProductModel::getOne($_GET['id']))
        ) {
            error404();
        }

        Cart::remove($produit);

        redirect('/cart');
    }

    static function update() {
        if (
            empty($_GET['id'])
            || empty($produit = ProductModel::getOne($_GET['id']))
        ) {
            error404();
        }

        if (
            empty($_POST['qtte'])
            || !is_numeric($_POST['qtte'])
        ) {
            add_flash('error', 'La quantité est incorrecte.');
        } else {
            Cart::updateQuantity($produit, $_POST['qtte']);
        }

        redirect('/cart');
    }

    static function displayCart() {
        $panier = Cart::getDetails();
        include view('cart/details');
    }

    static function empty() {
        Cart::empty();
        redirect('/cart');
    }
}
