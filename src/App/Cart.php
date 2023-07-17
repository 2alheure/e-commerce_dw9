<?php

namespace App;

use Models\ProductModel;

class Cart {

    /**
     * $_SESSION['cart'] = [
     *  ID => qtte,
     *  ID => qtte,
     *  ID => qtte,
     *  ID => qtte,
     * ]
     */

    static function add(object $produit, int $qtte) {
        $_SESSION['cart'][$produit->id] += $qtte;
    }

    static function updateQuantity(object $produit, int $qtte) {
        $_SESSION['cart'][$produit->id] = $qtte;
    }

    static function remove(object $produit) {
        unset($_SESSION['cart'][$produit->id]);
    }

    static function empty() {
        unset($_SESSION['cart']);
    }

    /**
     * Returns all the products (and their quantity)
     */
    static function getDetails(): array {
        $ret = [
            'total' => 0,
            'cart' => []
        ];

        foreach ($_SESSION['cart'] ?? [] as $id => $qtte) {
            $produit = ProductModel::getOne($id);

            if (!empty($produit)) {
                $ret['cart'][] = [
                    'product' => $produit,
                    'quantity' => $qtte,
                ];

                $ret['total'] += $qtte * $produit->prix;
            } else {
                add_flash('warning', 'Un produit de votre panier n\'est plus disponible. Il a été supprimé.');
                unset($_SESSION['cart'][$id]);
            }
        }

        return $ret;
    }
}
