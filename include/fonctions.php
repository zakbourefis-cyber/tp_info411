<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect(string $url): void {
    header("Location: $url");
    exit();
}

function requireLogin(string $url = 'login.php'): void {
    if (!isLoggedIn()) redirect($url);
}

function requireAdmin(string $url = '../index.php'): void {
    if (!isAdmin()) redirect($url);
}

// Échappe les caractères HTML pour éviter les XSS
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
