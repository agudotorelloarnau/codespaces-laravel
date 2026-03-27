<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    public function secret(): string
    {
        $key = config('app.key');

        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return hash('sha256', $key);
    }

    public function issue(User $user): string
    {
        $now = time();

        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'iat' => $now,
            'exp' => $now + 3600 * 24,
        ];

        return JWT::encode($payload, $this->secret(), 'HS256');
    }

    public function decode(string $token): ?\stdClass
    {
        try {
            return JWT::decode($token, new Key($this->secret(), 'HS256'));
        } catch (\Throwable $e) {
            return null;
        }
    }
}
