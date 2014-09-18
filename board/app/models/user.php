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
                'validate_between', self::MIN_USERNAME_LENGTH, self::MAX_USERNAME_LENGTH
            ),
        ),
        
        'password' => array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD_LENGTH, self::MAX_PASSWORD_LENGTH
            ),
        ),

        'confirm_password' => array(
            'match' => array(
                'is_match_password'
            ),
        ),
        
        'name' => array (
            'format' => array(
                'is_letters_only'
            ),
        ),
        
        'email' => array(
            'format' => array(
                'is_email_valid'
            ),
        ),
    );

    /*
    *Creates new user
    */
    public function register()
    {
        $this->validation['confirm_password']['match'][1] = $this->password;
        
        $this->validate();
        
        if ($this->hasError()) {
            throw new ValidationException("invalid inputs");
        }
        $params = array(
            'username' => $this->username,
            'password' => $this->password,
            'name' => $this->name,
            'email' => $this->email
        );
        
        $db = DB::conn();
        $db->insert('user', $params);
    }
    
    /*
    *Authenticates username and password
    */
    public function authenticate()
    {
        $query = "SELECT id, username, name FROM user WHERE username = ? AND password = ?";
        $db = DB::conn();
        $row = $db->row($query, array($this->username, $this->password));
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
