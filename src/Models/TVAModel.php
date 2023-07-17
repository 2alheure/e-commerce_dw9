<?php

namespace Models;

class TVAModel extends BaseModel {
    static function getAll(): array {
        return static::query('SELECT * FROM tva')
            ->fetchAll();
    }

    static function getOne($id): object {
        return static::query('SELECT * FROM tva WHERE id = ?', [$id])
            ->fetch();
    }
}
