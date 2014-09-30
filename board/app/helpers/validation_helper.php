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

<<<<<<< HEAD
=======
function is_alphanumeric($string)
{
    return ctype_alnum($string);
}

>>>>>>> dev_1.1_BAK
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
    return isset($_SESSION['username']);
}

function redirect($url)
{
    header("Location: $url");
<<<<<<< HEAD
=======
}

function is_admin()
{
    return $_SESSION['type'] === 'admin';
>>>>>>> dev_1.1_BAK
}