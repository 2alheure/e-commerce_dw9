<?php

namespace Controllers;

class StaticController {
    static function displayHomepage() {
        include view('static/home');
    }

    static function displayCGU() {
        include view('static/terms/cgu');
    }

    static function displayCGV() {
        include view('static/terms/cgv');
    }

    static function displayConfidentials() {
        include view('static/terms/confidentials');
    }
}
