<?php
// src/helpers.php

function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function redirect($url, $message = null, $type = 'success') {
    if ($message) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    header("Location: $url");
    exit();
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'success';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

function escape($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function validateRequired($field, $value, &$errors, $fieldName) {
    if (empty(trim($value))) {
        $errors[$field] = "Поле '$fieldName' обязательно для заполнения";
        return false;
    }
    return true;
}

function validateEmail($email, &$errors) {
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Введите корректный email адрес";
        return false;
    }
    return true;
}

function validatePhone($phone, &$errors) {
    $digits = preg_replace('/\D/', '', $phone);
    if (!empty($phone) && strlen($digits) < 10) {
        $errors['phone'] = "Введите корректный номер телефона (не менее 10 цифр)";
        return false;
    }
    return true;
}
