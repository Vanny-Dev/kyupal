<?php
// config/auth.php - Simple authentication helper

function isLoggedIn() {
    // Simple session-based authentication check
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

function login($username, $password) {
    // Simple hardcoded authentication (replace with proper authentication)
    if ($username === 'admin' && $password === 'password') {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    
    return false;
}

function logout() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    session_destroy();
}
?>