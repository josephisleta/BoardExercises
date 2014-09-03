<a class="btn btn-large btn-primary" href="<?php eh(url('thread/index')) ?>">Back to Home</a><br />
<h1>User Registration</h1>

<form class="well" method="post" action="<?php eh(url('user/register')) ?>">
	<label>Username</label>
	<input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
	<label>Password</label>
	<input type="password" class="span2" name="pword" value="<?php eh(Param::get('pword')) ?>">
	<label>Name</label>
	<input type="text" class="span2" name="name" value="<?php eh(Param::get('name')) ?>">
	<label>Email</label>
	<input type="text" class="span2" name="email" value="<?php eh(Param::get('email')) ?>">
	<br />
	
	<input type="hidden" name="page_next" value="register_end">
	
	<button type="submit" class="btn btn-primary">Register</button>
</form>
