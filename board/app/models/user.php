<?php
class User extends AppModel
{
	public function register($user)
	{
		$params = array(
			'username' => $this->username,
			'pword' => $this->pword,
			'name' => $this->name,
			'email' => $this->email
		);
		$db = DB::conn();
		$db->insert('user', $params);
		
	}
}
