<?php
class UserController extends AppController
{   
    /*
    *Get values in user registration form
    */
    public function register()
    {
        if (is_logged_in()) {
            redirect(url('thread/index'));
        }
        
        $user = new User;
        $page = Param::get('page_next','register');
        switch ($page) {
            case 'register':
                break;
            case 'register_end':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                $user->confirm_password = Param::get('confirm_password');
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                
                try {
                    $user->register($user);
                } catch (ValidationException $e) {
                    $page = 'register';
                }
                break;
            default:
                throw new NotFoundException("{$page} not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /*
    *Get and authenticate values entered in login form
    */
    public function login()
    {
        if (is_logged_in()) {
            redirect(url('thread/index'));
        }

        $user = new User;
        $page = Param::get('page_next', 'login');
        switch ($page) {
            case 'login':
                break;
            case 'home':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                try {
                    $account = $user->authenticate($user->username, $user->password);
                    $_SESSION['id'] = $account['id'];
                    $_SESSION['username'] = $account['username'];
                    $_SESSION['name'] = $account['name'];
                } catch (UserNotFoundException $e) {
                    $page = 'login';
                }
                break;
            default:
                throw new NotFoundException("{$page} not found");
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /*
    *Destroys the session of the user
    */
    public function logout()
    {
        session_destroy();
    }
}
