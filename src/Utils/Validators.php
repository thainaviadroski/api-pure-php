<?php

namespace App\Utils;

class Validators
{

    public static function validate(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                throw new \Exception("The field ($field) is required.");
            }
        }
        return $fields;
    }
}
