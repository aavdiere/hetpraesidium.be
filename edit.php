<?php

require_once 'core/init.php';

if (Input::exists('post', 'edit')) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'title' => array(
				'required' => true
			),
			'text' => array(
				'required' => true
			),
			'page' => array(
				'not' => '---'
			)
		));

		if ($validation->passed()) {
			$page = Input::get('year') == '---' ? Input::get('page') : Input::get('page') . "&year=" . Input::get('year');
			$DB->update('cms', Input::get('id'), array(
				'title'		=>	Input::get('title'),
				'text'		=>	nl2br(htmlentities(Input::get('text'))),
				'updated'	=>	Date('Y-m-d h:i:s'),
				'page'		=>	$page,
				'weight'	=>	Input::get('weight')
			));

			Redirect::to(Input::get('page'));
		} else {
			$flash = '';
			foreach ($validation->errors() as $key => $error) {
				$flash .= $error . '<br />'; 
			}
			Session::flash('edit.php', $flash);
			Redirect::to('', true);
		}
	}
}

if (Input::exists('post', 'delete')) {
	if (Token::check(Input::get('token'))) {
		$DB->delete('cms', array('id', '=', Input::get('id')));
		Redirect::to('index.php');
	}
}

if (Input::exists('get')) {
	if (Input::get('id') !== '') {

		$cms = $DB->get('cms', array('id', '=', Input::get('id')))->first();
		$pages = $DB->get('pages', array(), 'ORDER BY page ASC')->results();

		if (Session::exists('edit.php')) {
			echo "
				<div style='text-align: center;'>
					<h2>Opmerkingen</h2>
					<p>" . Session::flash('edit.php') . "</p>
				</div>
			";
		}

		?>

		<div>
			<form method="post">
				<div>
					<h2>Titel: </h2>
					<p><input type="name" name="title" value="<?php echo $cms->title ?>" /></p>
				</div>
				<div>
					<h2>Inhoud</h2>
					<p><textarea name="text" style="width: 100%; height: 300px;"><?php echo str_replace('<br />', '', $cms->text) ?></textarea></p>
				</div>
				<div>
					<h2>Pagina</h2>
					<p>
						<select name="page" id="pages">
							<option class="page" value="---">---</option>
							<?php
								foreach ($pages as $page) {
									if ($page->page === explode('&year=', $cms->page)[0]) {
										echo "<option selected class='page' value='$page->page'>$page->page</option>";
									} else {
										echo "<option class='page' value='$page->page'>$page->page</option>";
									}
								}
							?>
						</select>
						<select name="year" id="year">
							<option value="---">---</option>
							<?php
								for ($i=2014; $i < 2100; $i++) {
									if ($i == explode('&year=', $cms->page)[1]) {
										echo "<option selected value='$i'>$i</option>";
									} else {
										echo "<option value='$i'>$i</option>";
									}
								}
							?>
						</select>
					</p>
				</div>
				<div>
					<h2>Positie</h2>
					<p>
						Hoe lager dit getal, hoe hoger de tekst komt te staan op de pagina<br />
						<input type="number" name="weight" value="<?php echo $cms->weight ?>" min="-50" max="50" />
					</p>
				</div>
				<div>
					<input type="hidden" name="id" value="<?php echo $cms->id ?>" />
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				</div>
				<div>
					<p>
						<input type="submit" value="Pas Aan" name="edit" />
						<input type="submit" value="Verwijder" name="delete" />
					</p>
				</div>
			</form>
		</div>

		<?php
	} else {

	}
} else {

}

require_once 'core/includes/footer.php';

?>

<script type="text/javascript">
	$('#pages').on('change', function() {
		$('.page:selected').each(function() {
			if (this.value == 'galabal.php') {
				$('#year').show();
			} else {
				$('#year').hide();
				$('#year option:contains("---")').prop('selected', true);
			};
		});
	});
</script>