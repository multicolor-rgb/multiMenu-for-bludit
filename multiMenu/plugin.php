<?php

class MultiMenu extends Plugin
{

	public function adminController()
	{

		#create new
		if (isset($_POST['submit'])) {

			$folder        = PATH_CONTENT . 'multiMenu/';
			$filename      = $folder . $_POST['title'] . '.json';
			$chmod_mode    = 0755;
			$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
			$jsonData = $_POST['json'];
			$folderClass    = $folder . 'folderClass/';
			$classFile = $folderClass . $_POST['title'] . '-class.json';

			$jsonClass = array("active" => @$_POST['active'], "classul" => @$_POST['classul'], "classulli" => @$_POST['classulli'], "classullia" => @$_POST['classullia'], "classulliul" => @$_POST['classulliul'], "classulliulli" => @$_POST['classulliulli'], "classulliullia" => @$_POST['classulliullia']);

			if (empty($_POST['json'])) {
				$jsonData = '[]';
			}

			if ($folder_exists) {
				file_put_contents($filename, $jsonData);
				mkdir($folderClass, 0755);
				file_put_contents($classFile, json_encode($jsonClass));

				echo $_POST['title'];
				echo ("<meta http-equiv='refresh' content='0'>");

				echo '<script>window.location.href = "' . DOMAIN_ADMIN . 'plugin/multimenu?&addMultiMenu&menuname=' . $_POST['title'] . '"</script>';
			};
		};;
	}

	public function adminView()
	{
		// Token for send forms in Bludit
		global $security;
		$tokenCSRF = $security->getTokenCSRF();



		if (isset($_GET['addMultiMenu'])) {
			include($this->phpPath() . 'PHP/addNew.php');
		} else {
			include($this->phpPath() . 'PHP/settings.php');
		}

		echo '<form style="background:#fafafa; border:solid 1px #ddd; text-align:center; padding:10px;" action="https://www.paypal.com/cgi-bin/webscr" class="moneyshot" method="post" target="_top" style="display:block;text-align:center;">
			<p style="margin:0;padding:0;margin-bottom:10px;">Support my work :)</p>
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL" />
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
			<img alt="" border="0" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" />
			</form>
<small style="text-align:center;width:100%;display:block;margin-top:10px;">
			<a href="https://www.jqueryscript.net/menu/Drag-Drop-Menu-Builder-For-Bootstrap.html">This plugin use some elements of this code</a>
</small>
			';
	}

	public function adminSidebar()
	{
		$pluginName = Text::lowercase(__CLASS__);
		$url = HTML_PATH_ADMIN_ROOT . 'plugin/' . $pluginName;
		$html = '<a id="current-version" class="nav-link" href="' . $url . '">✨ MultiMenu</a>';
		return $html;
	}
}



function multiMenu($name)
{

	global $page;
	$current =  $page->slug();


	global $SITEURL;

	$files = file_get_contents(PATH_CONTENT . 'multiMenu/' . $name . '.json');
	$class = file_get_contents(PATH_CONTENT . 'multiMenu/folderClass/' . $name . '-class.json');
	$jsClass = json_decode($class);
	$reJsonFiles = json_decode($files);


	echo '<ul class="' . $jsClass->classul . '">';

	foreach ($reJsonFiles as $item) {

		if (strpos($item->href, 'http') !== false) {
			$check = PATH_PAGES;
		} else {
			$check = PATH_PAGES . $item->href . '/';
		};




		if (file_exists($check)) {

			echo '
			<li class="' . ($jsClass->active == 'li' ? ($current == $item->href ? 'active current' : '') : "") . ' ' . $jsClass->classulli . ' ' . (isset($item->children) ? 'parent' : '') . '">
				<a href="'
				. (strpos($item->href, 'http') === false ?  DOMAIN_BASE . $item->href : $item->href) .

				'" target="' . $item->target . '" class="' . ($jsClass->active == 'a' ? ($current == $item->href ? 'active current' : '') : "") . ' ' . $jsClass->classullia . '">' . $item->text . '</a>';

			if (isset($item->children)) {
				echo '
				<ul class="' . $jsClass->classulliul . '">';
				foreach ($item->children as $subitem) {

					if (strpos($subitem->href, 'http') !== false) {
						$checkSub = PATH_PAGES;
					} else {
						$checkSub = PATH_PAGES . $item->href . '/';
					};


					if (file_exists($checkSub)) {
						echo '
						<li class="' . $jsClass->classulliulli . ' ' . ($jsClass->active == 'li' ? ($current == $subitem->href ? 'active current' : '') : "") . '">
							<a  class="' . ($jsClass->active == 'a' ? ($current == $subitem->href ? 'active current' : '') : "") . ' ' . $jsClass->classulliullia . '"
						href="' .  (strpos($subitem->href, 'http')  === false ?  DOMAIN_BASE . $subitem->href : $subitem->href) . '" target="' . $subitem->target . '">' . $subitem->text . '</a>';
					};

					//sub-sub
					if (isset($subitem->children)) {
						echo '
						<ul class="' . $jsClass->classulliul . '">';
						foreach ($subitem->children as $subsubitem) {

							if (strpos($subsubitem->href, 'http') !== false) {
								$checkSubSub = PATH_PAGES;
							} else {
								$checkSubSub = PATH_PAGES . $item->href . '/';
							};


							if (file_exists($checkSubSub)) {
								echo '
								<li class="' . $jsClass->classulliulli . ' ' . ($jsClass->active == 'li' ? ($current == $subsubitem->href ? 'active current' : '') : "") . '">
								<a href="' . (strpos($subsubitem->href, 'http')  === false ?  DOMAIN_BASE . $subsubitem->href : $subsubitem->href) . '"
								 class="' . ($jsClass->active == 'a' ? ($current == $subsub->href ? 'active current' : '') : "") . ' ' . $jsClass->classulliullia . '"
									 target="' . $subsubitem->target . '">' . $subsubitem->text . '</a>
									 </li>';
							};
						};
						echo '
						</ul>';
					};

					echo '
					</li>';
				};
				echo '
				</ul>';
			};

			echo '
			</li>';
		};
	};

	echo '
	</ul>';
};
