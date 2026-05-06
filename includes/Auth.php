<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    public static function check() {
        return isset($_SESSION['user_id']);
    }

    public static function user() {
        if(self::check()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'],
                'email' => $_SESSION['user_email']
            ];
        }
        return null;
    }

    public static function login($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['logged_in'] = true;
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function protect() {
        if(!self::check()) {
            header("Location: login.php");
            exit();
        }
    }

    public static function guest() {
        if(self::check()) {
            header("Location: index.php");
            exit();
        }
    }
}
?>