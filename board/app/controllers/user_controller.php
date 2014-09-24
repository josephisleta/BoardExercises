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
                $user->username = trim(Param::get('username'));
                $user->password = Param::get('password');
                $user->confirm_password = Param::get('confirm_password');
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                
                try {
                    $user->register();
                } catch (ValidationException $e) {
                    $page = 'register';
                }
                break;
            default:
                throw new PageNotFoundException("{$page} not found");
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
                    $account = $user->authenticate();
                    if ($account['type'] === 'banned') {
                        redirect(url('user/login'));
                    } else {
                        $_SESSION['id'] = $account['id'];
                        $_SESSION['username'] = $account['username'];
                        $_SESSION['name'] = $account['name'];
                        $_SESSION['type'] = $account['type'];
                    }
                } catch (UserNotFoundException $e) {
                    $page = 'login';
                }
                break;
            default:
                throw new UserNotFoundException("{$page} not found");
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /*
    *Edit user information
    */
    public function profile()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $user = new User;
        $user_info = User::get($_SESSION['id']);

        $page = Param::get('page_next','profile');
        switch ($page) {
            case 'profile':
                break;
            case 'profile_end':
                $user->username = trim(Param::get('username'));
                $user->password = Param::get('password');
                $user->confirm_password = Param::get('confirm_password');
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                
                try {
                    $user->updateProfile();
                    $account = $user->updateSession($_SESSION['id']);
                    $_SESSION['id'] = $account['id'];
                    $_SESSION['username'] = $account['username'];
                    $_SESSION['name'] = $account['name'];
                    $_SESSION['type'] = $account['type'];
                } catch (UserNotFoundException $e) {
                    $page = 'profile';
                }
                break;
            default:
                throw new UserNotFoundException("{$page} not found");
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function admin()
    {
        if (!is_logged_in() || !is_admin()) {
            redirect(url('user/login'));
        }

        $users = User::getAll();
        $action = Param::get('action');

        if (Param::get('id') && (isset($_POST['yes']))) {
            $user = new User;
            $user = User::get(Param::get('id'));

            $user->adminAction($user, $action);
            redirect(url('user/admin'));
        }

        $this->set(get_defined_vars());
    }

    /*
    *Destroys the session of the user
    *Redirects to login page
    */
    public function logout()
    {
        session_destroy();
        redirect(url('user/login'));
    }
}
