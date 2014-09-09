<?php

function validate_between($check, $min, $max)
{
	$n = mb_strlen($check);
	return $min <= $n && $n <= $max;
}

function match_password($pword, $confirm_pword)
{
	return $pword === $confirm_pword;
}

function letters_only($name)
{
	return preg_match ("/^[a-zA-Z\s]+$/",$name);
}

function email_valid($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_logged_in()
{
	if (!isset($_SESSION['username']) )
	{
		return false;
	}
	return true;
}

function redirect($url)
{
	switch ($url) {
		case 'user':
			header('Location: /thread/index');
			break;
		case 'not_logged_in':
			header('Location: /user/login');
			break;
		default:
			header('Location: /user/login');
			break;
	}
}