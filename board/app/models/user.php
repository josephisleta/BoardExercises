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
<<<<<<< HEAD
=======
            'format' => array(
                'is_alphanumeric'
            )
>>>>>>> dev_1.1_BAK
        ),
        
        'password' => array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD_LENGTH, self::MAX_PASSWORD_LENGTH
            ),
<<<<<<< HEAD
=======
            'format' => array(
                'is_alphanumeric'
            )
>>>>>>> dev_1.1_BAK
        ),

        'confirm_password' => array(
            'match' => array(
                'is_match_password'
<<<<<<< HEAD
            ),
        ),
        
        'name' => array (
            'format' => array(
                'is_letters_only'
            ),
=======
            )
        ),
        
        'name' => array(
            'format' => array(
                'is_letters_only'
            )
>>>>>>> dev_1.1_BAK
        ),
        
        'email' => array(
            'format' => array(
                'is_email_valid'
<<<<<<< HEAD
            ),
        ),
=======
            )
        )
>>>>>>> dev_1.1_BAK
    );

    /*
    *Creates new user
    */
    public function register()
    {
        $this->validation['confirm_password']['match'][1] = $this->password;
        
<<<<<<< HEAD
        $this->validate();
        
        if ($this->hasError()) {
=======
        if (!$this->validate()) {
>>>>>>> dev_1.1_BAK
            throw new ValidationException("invalid inputs");
        }
        $params = array(
            'username' => $this->username,
<<<<<<< HEAD
            'pword' => $this->password,
=======
            'password' => $this->password,
>>>>>>> dev_1.1_BAK
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
<<<<<<< HEAD
        $query = "SELECT id, username, name FROM user WHERE username = ? AND pword = ?";
=======
        $query = "SELECT id, username, name, type FROM user WHERE username = ? AND password = ?";
>>>>>>> dev_1.1_BAK
        $db = DB::conn();
        $row = $db->row($query, array($this->username, $this->password));
        if (!$row) {
            $this->is_failed_login = true;
            throw new UserNotFoundException('user not found');
        }
        return $row;
    }
<<<<<<< HEAD
    
=======

    /*
    *Get fields from a user
    *@param $user_id
    */
    public static function get($user_id)
    {
        $db = DB::conn();
        $row = $db->row(
            "SELECT * FROM user WHERE id = ?", 
            array($user_id)
        );

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
    }
    
    /*
    *Get all user from the database
    */
    public static function getAll()
    {
        $users = array();

        $query = "SELECT * FROM user ORDER BY registered DESC";
        
        $db = DB::conn();
        $rows = $db->rows($query);

        foreach ($rows as $row) {
            $users[] = new self($row);
        }
        return $users;
    }

    /*
    *Updates new user information
    */
    public function updateProfile()
    { 
        if (!$this->validate()) {
            throw new ValidationException("invalid inputs");
        }
        
        $params = array(
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email
        );
        
        $db = DB::conn();
        $db->update('user', $params, array('id' => $this->id));
    }

    /*
    *Change user password
    */
    public function updatePassword()
    {
        $this->validation['confirm_password']['match'][1] = $this->password;

        if (!$this->validate()) {
            throw new ValidationException("invalid inputs");
        }
        
        $db = DB::conn();
        $db->update('user', array('password' => $this->password), array('id' => $this->id));
    }

    /*
    *Change type of the user
    *@param $type
    */
    public function changeType($type)
    {
        $db = DB::conn();
        $db->update('user', array('type' => $type), array('id' => $this->id));
    }

>>>>>>> dev_1.1_BAK
    public function isFailedLogin()
    {
        return $this->is_failed_login;
    }
<<<<<<< HEAD
=======

    /*
    *Counts total Posts of the user
    *@param $user_id
    */
    public static function countPost($user_id)
    {
        $db = DB::conn();
        return $db->value(
            "SELECT count(id) FROM comment WHERE user_id = ?", 
            array($user_id)
        );
    }
>>>>>>> dev_1.1_BAK
}
