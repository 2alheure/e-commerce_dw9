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

/**
 * Checks a given file
 * 
 * @param stirng $name The name of the file in $_FILES superglobale
 * @param string $type The expected type of the file
 * @param int $size The expected max size of the file
 * @return bool Whether the file is OK or not
 */
function check_file(string $name, string $type, int $size): bool {
    return
        !empty($_FILES[$name])
        && str_starts_with($_FILES[$name]['type'], $type)
        && $_FILES[$name]['size'] < $size
        && $_FILES[$name]['error'] === 0;
}
