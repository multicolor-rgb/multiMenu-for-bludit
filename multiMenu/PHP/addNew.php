<?php

if (isset($_GET['menuname'])) {
	$classFile = file_get_contents(PATH_CONTENT . 'multiMenu/folderClass/' . $_GET['menuname'] . '-class.json');
	$jsClass = json_decode($classFile);
};; ?>

 

<style>
	.multiMenu .btn-sm .fas {
		color: #fff;
	}

	.multiMenu .list-group {
		margin: 0 !important
	}
</style>

<form method="POST">
	<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF; ?>">

	<div class="row multiMenu">

		<h3 class="lead mt-2 border-bottom pb-3">MultiMenu Creator</h3>

		<div class="col-md-12 d-flex align-items-center justify-content-end mb-4">
			<a href="
				<?php

				echo DOMAIN_ADMIN . 'plugin/multimenu';
				?>
				" class="btn btn-dark btn-sm text-light text-decoration-none" style="text-decoration:none;">
				Back to List
			</a>
		</div>

		<div class="col-md-12">

			<div class="card-header bg-primary text-white"><i class="fa fa-file"></i> Name settings</div>

			<div class="card-body border mb-2 rounded">
				<div class="form-group">
					<label for="title"> Menu Name (without space or special characters)</label>
					<input type="text" required name="title" pattern="[a-zA-Z0-9]+" value="<?php
																							if (isset($_GET['menuname'])) {
																								echo $_GET['menuname'];
																							} else {
																								echo '';
																							}; ?>" class="form-control mb-2">
				</div>
			</div>

			<div class="card class-options mb-2 ">
				<div class="card-header bg-primary text-light"><i class="fa fa-code"></i> Custom Classes (click to show)</div>
				<div class="card-body ">
					<label>
						<input type="radio" name="active" value="a" <?php
																	if (isset($_GET['menuname'])) {

																		if ($jsClass->active == 'a') {
																			echo 'checked';
																		}
																	}; ?>> Active class on [a]
					</label>

					<label>
						<input type="radio" name="active" value="li" class="ml-2" <?php
																					if (isset($_GET['menuname'])) {
																						if ($jsClass->active == 'li') {
																							echo 'checked';
																						}
																					}; ?>> Active class on [li]
					</label>

					<div class="form-group">
						<label for="title"> class for menu</label>
						<input type="text" name="classul" <?php
															if (isset($_GET['menuname'])) {
																echo  'value="' . $jsClass->classul . '" ';
															}; ?> class=" form-control mb-2">
					</div>

					<div class="form-group">
						<label for="title"> class for menu > li</label>
						<input type="text" name="classulli" <?php
															if (isset($_GET['menuname'])) {
																echo  'value="' . $jsClass->classulli . '" ';
															}; ?> class="form-control mb-2">
					</div>

					<div class="form-group">
						<label for="title"> class for menu > li > a</label>
						<input type="text" name="classullia" <?php
																if (isset($_GET['menuname'])) {
																	echo  'value="' . $jsClass->classullia . '" ';
																}; ?> class="form-control mb-2">
					</div>

					<div class="form-group">
						<label for="title"> class for menu > li > ul</label>
						<input type="text" name="classulliul" <?php
																if (isset($_GET['menuname'])) {
																	echo  'value="' . $jsClass->classulliul . '" ';
																}; ?> class="form-control mb-2">
					</div>

					<div class="form-group">
						<label for="title"> class for menu > li > ul > li</label>
						<input type="text" name="classulliulli" <?php
																if (isset($_GET['menuname'])) {
																	echo  'value="' . $jsClass->classulliulli . '" ';
																}; ?> class="form-control mb-2">
					</div>

					<div class="form-group">
						<label for="title"> class for menu li > ul > li > a</label>
						<input type="text" name="classulliullia" <?php
																	if (isset($_GET['menuname'])) {
																		echo  'value="' . $jsClass->classulliullia . '" ';
																	}; ?> class="form-control mb-2">
					</div>

				</div>
			</div>

			<div class="card border-primary mb-3 edit-items">
				<div class="card-header bg-primary text-white"><i class="fa fa-link"></i> Edit Items (click to show)</div>
				<div class="card-body">
					<div id="frmEdit" class="form-horizontal">
						<div class="form-group">
							<label for="text">Title</label>
							<div class="input-group">
								<input type="text" class="form-control item-menu" name="text" id="text" placeholder="Title">

							</div>
							<input type="hidden" name="icon" class="item-menu">
						</div>

						<div class="form-group">
							<label for="href">URL</label>
							<select type="text" class="form-control item-menu href-maker" id="href" name="href" placeholder="URL">
								<option value="extlink" class="form-control">External link</option>


								<?php
								$p = new Pages();

								global $pages;
								$pages->getStaticDB();; ?>

								<?php foreach ($pages->getStaticDB() as $page) {


									echo '<option value="' . $page . '">' . $p->db[$page]['title'] . '</option>';
								}; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="target">Target attribute</label>
							<select name="target" id="target" class="form-control item-menu">
								<option value="_self">Self</option>
								<option value="_blank">Blank</option>
								<option value="_top">Top</option>
							</select>
						</div>
						<div class="form-group d-none">
							<label for="title">Tooltip</label>
							<input type="text" name="titletooltip" class="form-control item-menu" id="title" placeholder="Tooltip">
						</div>
					</div>

					<div class="border p-2 bg-light">
						<button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fa fa-refresh"></i>
							Update
						</button>
						<button type="button" id="btnAdd" class="btn btn-info"><i class="fa fa-plus"></i>
							Add
						</button>
					</div>

					<div class="alert alert-success mt-2 alert-done d-none">
						Updated! save to see changes
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header bg-info text-white">
					<i class="fa fa-bars"></i> Menu
				</div>
				<div class="card-body">
					<ul id="myEditor" class="sortableLists list-group">
					</ul>
				</div>
			</div>

			<textarea id="out" class="form-control d-none" name="json" cols="50" rows="10"></textarea>

			<div class="bg-light border mb-2 p-2 mt-2 d-flex ">
				<input type="submit" value="Save Menu" name="submit" class="btn d-block btn-success">

			</div>
		</div>
	</div>

</form>

<script src="<?php echo $this->domainPath() . '/js/jquery-menu-editor.js'; ?>"></script>



<script>
	const ars = {
		<?php
		$count = 1;



		foreach ($pages->getStaticDB() as $file) {
			$p = new Pages();



			$filecount = count($p->db);

			echo '"' . $file . '":"' . $p->db[$file]['title'] . '"';

			if ($filecount > $count) {

				echo ',';
			};

			$count++;
		};
		?>
	};

	var arrayjson =
		<?php

		if (isset($_GET['menuname'])) {
			$folder        = PATH_CONTENT . 'multiMenu/';
			$filename      = $folder . $_GET['menuname'] . '.json';
			echo  file_get_contents($filename);
		} else {
			echo '[]';
		}; ?>

	;

	jQuery(document).ready(function() {



		// icon picker options
		var iconPickerOptions = {

		};
		// sortable list options
		var sortableListOptions = {
			placeholderCss: {
				'background-color': "#cccccc"
			}
		};

		var editor = new MenuEditor('myEditor', {
			listOptions: sortableListOptions
		});

		editor.setData(arrayjson);

		var str = editor.getString();
		$("#out").text(str);

		editor.setForm($('#frmEdit'));
		editor.setUpdateButton($('#btnUpdate'));
		$('#btnReload').on('click', function() {
			editor.setData(arrayjson);
			var str = editor.getString();
			$("#out").text(str);
		});

		$('#btnOutput').on('click', function() {
			var str = editor.getString();
			$("#out").text(str);
		});

		$('#btnOutput').on('mousedown', function() {
			var str = editor.getString();
			$("#out").text(str);
		});

		$("#btnUpdate").click(function() {
			editor.update();
			var str = editor.getString();
			$("#out").text(str);


			document.querySelector('.alert-done').classList.remove('d-none');
			setTimeout(() => {
				document.querySelector('.alert-done').classList.add('d-none');

			}, 1500);

			document.querySelector('.inputer').remove();
			document.querySelector('.href-maker').classList.add('item-menu');

		});

		$('#btnAdd').click(function() {
			editor.add();
			var str = editor.getString();
			$("#out").text(str);
		});


		$('#myEditor').click(function() {
			var str = editor.getString();
			$("#out").text(str);
		});

		$('#href').click(function() {
			$('#text').val(
				ars[$('#href').val()]
			);
		});

		//
		document.querySelector('.class-options').style.cursor = "pointer";
		document.querySelector('.class-options').querySelector('.card-body').classList.add('d-none');
		document.querySelector('.class-options').querySelector('.card-header').addEventListener('click', () => {
			document.querySelector('.class-options').querySelector('.card-body').classList.toggle('d-none');
		});


		document.querySelector('.edit-items').style.cursor = "pointer";
		document.querySelector('.edit-items').querySelector('.card-body').classList.add('d-none');
		document.querySelector('.edit-items').querySelector('.card-header').addEventListener('click', () => {
			document.querySelector('.edit-items').querySelector('.card-body').classList.toggle('d-none');
		})

		let count = 0;

		if (document.querySelector('.href-maker').value == 'extlink') {
			const inputer = document.createElement('input');
			document.querySelector('.href-maker').classList.remove('item-menu');
			inputer.setAttribute('name', 'href');
			inputer.setAttribute('id', 'href');
			inputer.setAttribute('placeholder', 'https://google.pl');
			inputer.classList.add('item-menu', 'form-control', 'inputer', 'mt-2');


			if (document.querySelector('.inputer') == undefined) {
				document.querySelector('.href-maker').after(inputer);
			};


		} else {
			if (document.querySelector('.inputer') !== null) {
				document.querySelector('.inputer').remove();
			}
		};

		document.querySelector('.href-maker').addEventListener('click', () => {
			if (document.querySelector('.href-maker').value == 'extlink') {
				const inputer = document.createElement('input');
				document.querySelector('.href-maker').classList.remove('item-menu');
				inputer.setAttribute('name', 'href');
				inputer.setAttribute('id', 'href');
				inputer.setAttribute('placeholder', 'https://google.pl')
				inputer.classList.add('item-menu', 'form-control', 'inputer', 'mt-2');

				if (document.querySelector('.inputer') == undefined) {
					document.querySelector('.href-maker').after(inputer);
				}

			} else {
				if (document.querySelector('.inputer') !== null) {
					document.querySelector('.inputer').remove();
					document.querySelector('.href-maker').classList.add('item-menu');
				}
			};
		});


		document.querySelectorAll('.btnEdit').forEach((item, i) => {

			item.addEventListener('click', () => {


				setTimeout(() => {

					if (document.querySelector('.href-maker').value !== 'extlink') {
						if (document.querySelector('.inputer') !== null) {
							document.querySelector('.inputer').remove();
							document.querySelector('.href-maker').classList.add('item-menu');
						}
					} else {

						const inputer = document.createElement('input');
						document.querySelector('.href-maker').classList.remove('item-menu');
						inputer.setAttribute('name', 'href');
						inputer.setAttribute('id', 'href');
						inputer.setAttribute('placeholder', 'https://google.pl');
						inputer.value = arrayjson[i]['href'];
						inputer.classList.add('item-menu', 'form-control', 'inputer', 'mt-2');

						if (document.querySelector('.inputer') == undefined) {
							document.querySelector('.href-maker').after(inputer);
						};

					};




				}, 100)

				document.querySelector('.edit-items .card-body').classList.remove('d-none');

			});

		});


	});
</script>