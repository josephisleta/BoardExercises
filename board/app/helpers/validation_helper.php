<?php

function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

function is_match_password($password, $confirm_password)
{
    return $password === $confirm_password;
}

function is_letters_only($name)
{
    return ctype_alpha($name);
}

function is_email_valid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_logged_in()
{
    if (!isset($_SESSION['username'])) {
        return false;
    }
    return true;
}

function redirect($url)
{
    header("Location: $url");
}