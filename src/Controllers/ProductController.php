<?php

namespace Controllers;

use Models\ProductModel;
use Models\TVAModel;

class ProductController {
    static function list() {
        $produits = ProductModel::getAll();
        include view('products/list');
    }

    static function details() {
        if (
            empty($_GET['id'])
            || empty($produit = ProductModel::getOne($_GET['id']))
        ) {
            error404();
        }

        include view('products/details');
    }

    static function displayUpdateForm() {
        if (
            empty($_GET['id'])
            || empty($produit = ProductModel::getOne($_GET['id']))
        ) {
            error404();
        }

        if (!has_role('ADMIN')) {
            error403();
        }

        $tvas = TVAModel::getAll();
        $isUpdate = true;
        include view('products/form');
    }

    static function displayCreateForm() {
        if (!has_role('ADMIN')) {
            error403();
        }

        $tvas = TVAModel::getAll();
        $isUpdate = false;
        include view('products/form');
    }

    static function delete() {
        if (empty($_GET['id'])) {
            error404();
        }

        if (!has_role('ADMIN')) {
            error403();
        }

        ProductModel::delete($_GET['id']);
        add_flash('success', 'Produit supprimé avec succès.');
        redirect('/products/list');
    }

    static function handleUpdateForm() {
        if (
            empty($_GET['id'])
            || empty($produit = ProductModel::getOne($_GET['id']))
        ) {
            error404();
        }

        if (!has_role('ADMIN')) {
            error403();
        }

        if (static::checkForm(true)) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                // S'il y a un fichier, on l'upload
                $image = upload($_FILES['image'], __DIR__ . '/../../assets/img/products');
            }

            ProductModel::update(
                $_GET['id'],
                htmlspecialchars($_POST['nom']),
                $_POST['stock'],
                htmlspecialchars($_POST['description']),
                $_POST['prix'],
                $_POST['tva_id'],
                $image ?? $produit->image
            );

            add_flash('success', 'Produit modifié avec succès.');
        }

        redirect('/products/update?id=' . $_GET['id']);
    }

    static function handleCreateForm() {
        if (!has_role('ADMIN')) {
            error403();
        }

        if (static::checkForm()) {
            $image = upload($_FILES['image'], __DIR__ . '/../../assets/img/products');
            
            ProductModel::create(
                htmlspecialchars($_POST['nom']),
                $_POST['stock'],
                htmlspecialchars($_POST['description']),
                $_POST['prix'],
                $_POST['tva_id'],
                $image
            );
            
            add_flash('success', 'Produit créé avec succès.');
            redirect('/products/list');
        } 

        redirect('/products/create');
    }

    static private function checkForm(bool $isUpdate = false): bool {
        $error = false;

        if (empty($_POST['nom'])) {
            add_flash('error', 'Le nom est requis.');
            $error = true;
        }

        if (empty($_POST['description'])) {
            add_flash('error', 'La description est requise.');
            $error = true;
        }

        if (
            empty($_POST['stock'])
            || !is_numeric($_POST['stock'])
            || $_POST['stock'] < 0
        ) {
            add_flash('error', 'Le stock est requis et doit être un nombre positif ou nul.');
            $error = true;
        }

        if (
            empty($_POST['prix'])
            || !is_numeric($_POST['prix'])
            || $_POST['prix'] < 0
        ) {
            add_flash('error', 'Le prix est requis et doit être un nombre positif ou nul.');
            $error = true;
        }

        if (
            empty($_POST['tva_id'])
            || empty(TVAModel::getOne($_POST['tva_id']))
        ) {
            add_flash('error', 'Une TVA correcte est requise.');
            $error = true;
        }

        if ($isUpdate) {
            if (
                $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE // If there is a file
                && !check_file('image', 'image/', 5_000_000)
                ) {
                    $error = true;
                    add_flash('error', 'Le fichier fourni n\'est pas correct.');
                }
        }

        return !$error;
    }
}
