<?php

namespace Controllers;

use App\Cart;

class TestController {
    static function test() {
        $_SESSION['cart'] = [
            1 => 2,
            3 => 1,
        ];

        dd(Cart::getDetails());
    }
}
