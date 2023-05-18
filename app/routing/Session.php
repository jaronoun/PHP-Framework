<?php

namespace Isoros\routing;

use Isoros\models\User;

class Session {
    private string $session_id;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None'
            ]);
            session_start();
        }
        $this->session_id = session_id();
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key): String|null
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete($key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function regenerate(): void
    {
        session_regenerate_id(true);
        $this->session_id = session_id();
    }

    public function getId(): string
    {
        return $this->session_id;
    }
}