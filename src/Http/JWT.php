<?php

namespace App\Http;

class JWT
{
    private static string $secret = 'secret-key';

    public static function generate(array $data = [])
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($data);

        $encodeHeader = self::encodeURL($header);
        $encodePayload = self::encodeURL($payload);

        $signature = self::signature($encodeHeader, $encodePayload);

        $jwt = $encodeHeader . "." . $encodePayload . "." . $signature;

        return $jwt;
    }


    public static function signature(string $header, string $payload)
    {
        $signature = hash_hmac('sha256', $header . "." . $payload, self::$secret, true);
        return self::encodeURL($signature);
    }


    public static function encodeURL($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function decodeURL($data)
    {
        $padding = strlen($data) % 4;
        $padding !== 0 && $data .= str_repeat('=', $padding - 4);

        $data = strtr($data, '-_', '+/');

        return base64_decode($data);
    }
}
