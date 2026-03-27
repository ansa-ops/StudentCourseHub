<?php
function sanitise_string($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function sanitise_email($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sanitise_int($value) {
    return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}

function safe_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>