<?php

namespace Models;

class UserModel extends BaseModel {
    static function getByEmail(string $email) {
        $stmt = static::query('SELECT * FROM utilisateur WHERE email = ?', [$email]);
        return $stmt->fetch();
    }

    static function add(string $email, string $password): object {
        static::query(
            'INSERT INTO utilisateur (email, password, role_id) VALUE (:email, :psw, 1)',
            [
                'psw' => $password,
                'email' => $email,
            ]
        );

        return static::getByEmail($email);
    }
}
