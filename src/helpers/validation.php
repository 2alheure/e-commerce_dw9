<?php

/**
 * Validates an email
 * 
 * @param string $email The email to validate
 * @return bool Whether the email is valid or not
 */
function check_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validates a new password
 */
function check_password(string $password): bool {
    return preg_match('#\d#', $password) // A digit
        && preg_match('#[a-z]#', $password) // A lowercase letter
        && preg_match('#[A-Z]#', $password) // An uppercase letter
        && preg_match('#[!@\#$%^&*()_+\-=\[\]{};\':"\\|,.<>/?]#', $password) // A special character
        && strlen($password) >= 8; // 8 characters min
}
