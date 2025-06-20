<?php

namespace App\Services;

use App\Http\JWT;
use App\Utils\Validators;
use App\Models\User;
use Exception;

class UserService
{
    public static function create(array $data)
    {

        try {
            $fields = Validators::validate([
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? ''
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $user = User::save($fields);

            if (!$user) return ['error' => "Sorry, we could not create your account."];

            return "User created successfully!";
        } catch (\PDOException $err) {
            return ['error' => $err->getMessage()];
        } catch (\Exception $err) {
            return ['error' => $err->getMessage()];
        }
    }


    public static function fetch(mixed $authorization)
    {
        try {

            if (isset($authorization['error'])) {
                return ['error' => $authorization['error']];
            }


            return $authorization;
        } catch (\PDOException $err) {
            return ['error' => $err->getMessage()];
        } catch (\Exception $err) {
            return ['error' => $err->getMessage()];
        }
    }


    public static function auth(array $data)
    {
        try {
            $fields = Validators::validate([
                'email'    => $data['email']    ?? '',
                'password' => $data['password'] ?? '',
            ]);

            $user = User::authentication($fields);

            if (!$user) return ['error' => 'Sorry, we could not athenticate you.'];

            return JWT::generate($user);
        } catch (\PDOException $err) {
            return ['error' => $err->getMessage()];
        } catch (\Exception $err) {
            return ['error' => $err->getMessage()];
        }
    }
}
