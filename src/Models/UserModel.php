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

    static function update($id, string $email, string $password, ?string $avatar, ?string $telephone, ?string $prenom, ?string $nom): object {
        static::query(
            'UPDATE utilisateur 
            SET email = :email,password = :password,image = :avatar,telephone = :telephone,prenom = :prenom,nom = :nom
            WHERE id = :id',
            [
                'email' => $email,
                'password' => $password,
                'avatar' => $avatar,
                'telephone' => $telephone,
                'prenom' => $prenom,
                'nom' => $nom,
                'id' => $id
            ]
        );

        return static::getByEmail($email);
    }

    static function delete($id) {
        static::query('DELETE FROM utilisateur WHERE id = ?', [$id]);
    }
}
