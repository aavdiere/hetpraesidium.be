<?php
function delete() {
	GLOBAL $user;
	if ($user->isLoggedIn() && $user->hasPermission('editor')) {
		echo '
		<div>
			<h3>Verwijder Event</h3>
			<p>
				<form action="deleteEvent.php" method="post">
					<input name="year" value="' . Input::get('year') .'" type="hidden">
					<input type="submit" name="delete" value="Delete">
					<input type="hidden" name="event" value="' . Input::get('event') .'">
				</form>
			</p>
		</div>';
	}
}
?>