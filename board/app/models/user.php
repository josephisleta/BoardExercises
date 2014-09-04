<?php
class User extends AppModel
{
	const MIN_USERNAME_LENGTH = 6;
	const MAX_USERNAME_LENGTH = 20;
	const MIN_PASSWORD_LENGTH = 6;
	const MAX_PASSWORD_LENGTH = 20;

	private $is_failed_login = false;

	public $validation = array(
		'username' => array(
			'length' => array(
				'validate_between', self::MIN_USERNAME_LENGTH, self::MAX_USERNAME_LENGTH,
			),
		),
		
		'pword' => array(
			'length' => array(
				'validate_between', self::MIN_PASSWORD_LENGTH, self::MAX_PASSWORD_LENGTH,
			),
		),
		'confirm_pword' => array(
			'match' => array(
				'match_password',
			),
		),

		'name' => array (
			'format' => array(
				'letters_only',
			),
		),

		'email' => array(
			'format' => array(
				'email_valid',
			),
		),
	);

	public function register($user)
	{
		$this->validation['confirm_pword']['match'][] = $this->pword;
		$this->validation['confirm_pword']['match'][] = $this->confirm_pword;
		$this->validation['name']['format'][] = $this->name;
		$this->validation['email']['format'][] = $this->email;
		
		$this->validate();

		if($this->hasError()) {
			throw new ValidationException("invalid inputs");
		} else {
			$params = array(
				'username' => $this->username,
				'pword' => $this->pword,
				'name' => $this->name,
				'email' => $this->email
			);
		}

		$db = DB::conn();
		$db->insert('user', $params);
		
	}

	public function authenticate($username, $pword)
	{
		$query = "SELECT id, username, name FROM user WHERE username = ? AND pword = ?";
		$db = DB::conn();
		$row = $db->row($query, array($username, $pword));
		if (!$row) {
			$this->is_failed_login = true;
			throw new UserNotFoundException('user not found');
		}
		return $row;
	}

	public function isFailedLogin()
	{
		return $this->is_failed_login;
	}
}
