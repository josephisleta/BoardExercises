<h1>Board Exercise</h1>

<ul>
	<?php foreach ($threads as $v): ?>
	<li>
		<a href="<?php eh(url('thread/view',array('thread_id' => $v->id)))?>">
			<b><?php eh($v->title) ?></b>
		</a>
		<br /><pre><?php eh($v->username) ?>&#9;<?php eh($v->created) ?></pre>
	</li>
	<?php endforeach ?>
</ul>

<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
<a class="btn btn-large btn-primary" href="<?php eh(url('user/register')) ?>">Register</a>
