<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class  User extends Database
{

    public static function save(array $data)
    {
        $con = self::getConnection();

        $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");

        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password'],
        ]);

        return $con->lastInsertId() > 0 ? true : false;
    }

    public static function findOne(int| string $id)
    {
        $con = self::getConnection();

        $stmt = $con->prepare("SELECT * FROM users WHERE id = ? ;");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function authentication(array $data)
    {
        $con = self::getConnection();

        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? ;");

        $stmt->execute([$data['email']]);

        if ($stmt->rowCount() < 1) return false;

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($data['password'], $user['password'])) return false;

        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];
    }
}
