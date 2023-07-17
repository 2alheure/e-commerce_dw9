<?php

namespace Models;

class ProductModel extends BaseModel {
    static function getAll(): array {
        return static::query('SELECT * FROM produit')
            ->fetchAll();
    }

    static function getOne($id): object {
        return static::query('SELECT * FROM produit WHERE id = ?', [$id])
            ->fetch();
    }

    static function create(string $nom, int $stock, string $description, float $prix, int $tva_id, string $image): object {
        return static::query('INSERT INTO produit VALUE (NULL, :stock, :nom, :prix, :desc, :img, :tva)', [
            'prix' => $prix,
            'stock' => $stock,
            'img' => $image,
            'desc' => $description,
            'nom' => $nom,
            'tva' => $tva_id,
        ]);
    }

    static function update($id, string $nom, int $stock, string $description, float $prix, int $tva_id, string $image): object {
        return static::query(
            'UPDATE produit SET
            prix = :prix,
            stock = :stock,
            image = :img,
            description = :desc,
            nom = :nom,
            tva_id = :tva
        WHERE id = :id',
            [
                'prix' => $prix,
                'stock' => $stock,
                'img' => $image,
                'desc' => $description,
                'nom' => $nom,
                'tva' => $tva_id,
                'id' => $id
            ]
        );
    }

    static function delete($id) {
        return static::query('DELETE FROM produit WHERE id = ?', [$id]);
    }
}
