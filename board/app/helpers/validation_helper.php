<?php

function validate_between($check, $min, $max)
{
	$n = mb_strlen($check);

	return $min <= $n && $n <= $max;
}

function letters_only($name)
{
	return preg_match ("/^[a-zA-Z\s]+$/",$name);
}

function match_password($pword, $confirm_pword)
{
	return $pword === $confirm_pword;
}

function email_valid($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}