<?php
class UserController extends AppController
{
	public function register()
	{
		$user = new User;
		$page = Param::get('page_next','register');
		switch ($page) {
			case 'register':
				break;
			case 'register_end':
				$user->username = Param::get('username');
				$user->pword = Param::get('pword');
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
}