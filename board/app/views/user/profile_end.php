<table style="width: 100%;">
<tr>
	<td>
		<a class='btn btn-primary' href="<?php encode(url('thread/index'))?>">Back to home</a>
	</td>
	<td style="text-align:right;">
		<p><em>You are logged in as :</em>
			<?php encode($_SESSION['username'])?>
			<a class="btn btn-mini" href="<?php encode(url('user/profile')) ?>">Profile</a>
			<a class="btn btn-mini btn-danger" href="<?php encode(url('user/logout')) ?>">Logout</a>
		</p>
	</td>
</tr>
</table>
<h1>Congratulations!</h1>
<p class="alert alert-success">
Your account was successfully updated.
</p>