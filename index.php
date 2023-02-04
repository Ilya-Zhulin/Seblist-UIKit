<?php
/**
 * @version 		SEBLOD 3.x More
 * @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
 * @url				http://www.seblod.com
 * @editor			Octopoos - www.octopoos.com
 * @copyright		Copyright (C) 2013 SEBLOD. All Rights Reserved.
 * @license 		GNU General Public License version 2 or later; see _LICENSE.php
 * */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

// -- Initialize
require_once dirname(__FILE__) . '/config.php';
$cck = CCK_Rendering::getInstance($this->template);
if ($cck->initialize() === false) {
	return;
}

// -- Prepare
$display_mode	 = (int) $cck->getStyleParam('list_display', '0');
$display_view	 = $cck->getStyleParam('list_display_view', 'grid');
$id_class		 = $cck->getStyleParam('rendering_css_class', '');
$id_attr		 = $cck->getStyleParam('rendering_item_attributes', '');

// -- CSS assets
$css_include = $cck->getStyleParam('css_include', '0');
if ($css_include != 0) {
	$css_scripts = $cck->getStyleParam('css_scripts', '');
	if (strlen($css_scripts) > 0) {
		$css_scripts_ar	 = array();
		$css_scripts_ar	 = explode(PHP_EOL, $cck->getStyleParam('css_scripts', ''));
	}
	$css_code = $cck->getStyleParam('css_code', '');
	if (count($css_scripts_ar) > 0 || strlen($css_code) > 0) {
		$doc = Factory::getDocument();
		if (count($css_scripts_ar) > 0) {
			foreach ($css_scripts_ar as $css_item) {
				$doc->addStyleSheet($css_item);
			}
		}
		if (strlen($css_code) > 0) {
			$doc->addStyleDeclaration($css_code);
		}
	}
}

// -- JS assets
$js_include = $cck->getStyleParam('js_include', '0');
if ($js_include != 0) {
	$js_scripts = $cck->getStyleParam('js_scripts', '');
	if (strlen($js_scripts) > 0) {
		$js_scripts_ar	 = array();
		$js_scripts_ar	 = explode(PHP_EOL, $cck->getStyleParam('js_scripts', ''));
	}
	$js_code = $cck->getStyleParam('js_code', '');
	if (count($js_scripts_ar) > 0 || strlen($js_code) > 0) {
		$doc = Factory::getDocument();
		if (count($js_scripts_ar) > 0) {
			foreach ($js_scripts_ar as $js_item) {
				$doc->addScript($js_item);
			}
		}
		if (strlen($js_code) > 0) {
			$doc->addScriptDeclaration($js_code);
		}
	}
}
?>

<?php if ($id_class || $id_attr) : ?>
	<div class="<?php echo trim($id_class); ?>"<?php
	echo trim($id_attr);
	?>>
		 <?php endif;
		 ?>
		 <?php require dirname(__FILE__) . '/includes/' . $display_view . '.php'; ?>
		 <?php if ($id_class) : ?>
	</div>
<?php endif; ?>

<?php
// -- Finalize
$cck->finalize();
?>