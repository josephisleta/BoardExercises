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
        
        'password' => array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD_LENGTH, self::MAX_PASSWORD_LENGTH,
            ),
        ),

        'confirm_password' => array(
            'match' => array(
                'is_match_password',
            ),
        ),
        
        'name' => array (
            'format' => array(
                'is_letters_only',
            ),
        ),
        
        'email' => array(
            'format' => array(
                'is_email_valid',
            ),
        ),
    );

    /*
    *Creates new user
    *@param $user
    */
    public function register($user)
    {
        $this->validation['confirm_password']['match'][] = $this->password;
        $this->validation['confirm_password']['match'][] = $this->confirm_password;
        $this->validation['name']['format'][] = $this->name;
        $this->validation['email']['format'][] = $this->email;
        
        $this->validate();
        
        if ($this->hasError()) {
            throw new ValidationException("invalid inputs");
        }
        $params = array(
            'username' => $this->username,
            'pword' => $this->password,
            'name' => $this->name,
            'email' => $this->email
        );
        
        $db = DB::conn();
        $db->insert('user', $params);
    }
    
    /*
    *Authenticates username and password
    *@param $username, $password
    */
    public function authenticate($username, $password)
    {
        $query = "SELECT id, username, name FROM user WHERE username = ? AND pword = ?";
        $db = DB::conn();
        $row = $db->row($query, array($username, $password));
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
