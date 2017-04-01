<?php
	function edit($id) {
		GLOBAL $user;
		if ($user->isLoggedIn() && $user->hasPermission('editor')) {
			return "<p style='text-align: right;'><a href='edit.php?id=$id'>Edit</a></p>";
		}
	}
	function show() {
		$DB = DB::getInstance();
		$cms_texts = $DB->get('cms', array('page', '=', curPage(true)), 'ORDER BY weight ASC')->results();
		$temp = '';
		foreach ($cms_texts as $key => $cms) {
			$temp .= "
				<div>
					<h3>$cms->title</h3>
					<p>" . html_entity_decode($cms->text) . "</p>
					" . edit($cms->id) . "
				</div>
			";
		}
		echo $temp;
	}
?>