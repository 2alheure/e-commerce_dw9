<?php

namespace Models;

use App\Command;

class CommandModel extends BaseModel {
    static function getOne($id): object {
        return static::query('SELECT * FROM commande WHERE id = ?', [$id])
            ->fetch();
    }

    static function create(int $user_id, int $mode_livraison, int $mode_paiement, string $adresse_livraison, string $adresse_facturation): object {
        static::query(
            'INSERT INTO commande (utilisateur_id, etat_id, mode_paiement_id, mode_livraison_id, date, token, adresse_livraison, adresse_facturation)
            VALUE (?, 1, ?, ?, ?, ?, ?, ?)',
            [
                $user_id,
                $mode_paiement,
                $mode_livraison,
                date('Y-m-d'),
                token(),
                $adresse_livraison,
                $adresse_facturation
            ]
        );

        return static::getLast();
    }

    static function getLast(): object {
        return static::query('SELECT * FROM commande ORDER BY id DESC')
            ->fetch();
    }

    static function getLastNumero(): string {
        return static::query('SELECT numero FROM commande ORDER BY numero DESC WHERE numero IS NOT NULL')
            ->fetch()->numero;
    }

    static function addProduct(int $commande_id, int $produit_id, int $qtte) {
        static::query(
            'INSERT INTO produit_commande VALUE (NULL, ?, ?, ?)',
            [
                $produit_id,
                $commande_id,
                $qtte
            ]
        );
    }

    /**
     * Updates a command to set it as it is payed
     */
    static function payed(string $token) {
        $lastNumero = static::getLastNumero();

        if (!empty($lastNumero)) {
            $lastNumero = substr($lastNumero, 6);
            $numero = date('y-m-') . ($lastNumero + 1);
        } else {
            $numero = date('y-m-') . 1;
        }

        static::query(
            'UPDATE commande SET numero = ?, etat_id = ? WHERE token = ?',
            [
                $numero,
                Command::ETAT_PAYEE,
                $token
            ]
        );
    }

    static function getAllMoyensPaiement(): array {
        return static::query('SELECT * FROM mode_paiement')
            ->fetchAll();
    }

    static function getAllMoyensLivraison(): array {
        return static::query('SELECT * FROM mode_livraison')
            ->fetchAll();
    }

    static function getOneMoyenPaiement($id): array {
        return static::query('SELECT * FROM mode_paiement WHERE id = ?', [$id])
            ->fetchAll();
    }

    static function getOneMoyenLivraison($id): array {
        return static::query('SELECT * FROM mode_livraison WHERE id = ?', [$id])
            ->fetchAll();
    }
}
