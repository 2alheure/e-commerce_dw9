<?php

namespace Controllers;

class ContactController {
    static function displayContact() {
        include view('static/contact');
    }

    static function handleContact() {
        // dump & die
        dd($_POST);
    }
}
