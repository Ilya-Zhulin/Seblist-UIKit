<?php
/* Grid Template Style */

defined('_JEXEC') or die;
$app					 = JFactory::getApplication();
$html					 = '';
$items					 = $cck->getItems();
$fieldnames				 = $cck->getFields('uk-grid', '', false);
$multiple				 = (count($fieldnames) > 1) ? true : false;
$count					 = count($items);
$uk_grid_ul_class		 = trim($cck->getStyleParam('uk_grid_ul_class', ''));
$uk_grid_ul_class		 = $uk_grid_ul_class ? ' class="' . $uk_grid_ul_class . '"' : '';
$uk_grid_ul_attribute	 = trim($cck->getStyleParam('uk_grid_ul_attribute', ''));
$uk_grid_ul_attribute	 = $uk_grid_ul_attribute ? $uk_grid_ul_attribute : '';

$uk_grid_li_class		 = trim($cck->getStyleParam('uk_grid_li_class', ''));
$uk_grid_li_class		 = $uk_grid_li_class ? ' class="' . $uk_grid_li_class . '"' : '';
$uk_grid_li_attribute	 = trim($cck->getStyleParam('uk_grid_li_attribute', ''));
$uk_grid_li_attribute	 = $uk_grid_li_attribute ? $uk_grid_li_attribute : '';

$search_name = $cck->type;
//JBDump($app->getMenu()->getActive());

$search_options = JCckDatabase::loadResult('select options from #__cck_core_searchs where name="model_wheels"');

$search_options_obj = JCckDev::fromJSON($search_options);

$pagination = (isset($search_options_obj['pagination'])) ? $search_options_obj['pagination'] : '';

if ($pagination > 0) {
	$p = (isset($_GET['p'])) ? $_GET['p'] : 1;
} else {
	$limit = $count;
}
//JBDump($display_mode, 1);
// $cck->addStyleSheet($cck->base.'/templates/'.$cck->template.'/css/custom.css');
// $cck->addScript($cck->base.'/templates/'.$cck->template.'/js/custom.js');
$q = 0;
?>
<ul <?php echo $uk_grid_ul_class; ?> <?php echo $uk_grid_ul_attribute; ?>>
	<?php
	if ($count) {
		if ($display_mode == 2) {
			foreach ($items as $item) {
				$q++;
				if ($q <= $p * $pagination && $q > $pagination * ($p - 1)) {
					$row = $item->renderPosition('uk-grid');
					if ($row) {
						$row = '<li ' . $uk_grid_li_class . ' ' . $uk_grid_li_attribute . '>' . $row . '</li>';
					}
					$html .= $row;
				}
			}
		} elseif ($display_mode == 1) {
			foreach ($items as $pk => $item) {
				$row = $cck->renderItem($pk);
				if ($row) {
					$row = '<li' . $uk_grid_li_class . '' . $uk_grid_li_attribute . '>' . $row . '</li>';
				}
				$html .= $row;
			}
//			}
		} else {
			foreach ($items as $item) {
				$q++;
				if ($q <= $p * $pagination && $q > $pagination * ($p - 1)) {
					$row = '';
					foreach ($fieldnames as $fieldname) {
						$content = $item->renderField($fieldname);
						if ($content != '') {
							if ($item->getMarkup($fieldname) != 'none' && ( $multiple || $item->getMarkup_Class($fieldname) )) {
								$row .= '<div class="uk-clearfix' . $item->getMarkup_Class($fieldname) . '">' . $content . '</div>';
							} else {
								$row .= $content;
							}
						}
					}
					if ($row) {
						$row = '<li ' . $uk_grid_li_class . ' ' . $uk_grid_li_attribute . '>' . $row . '</li>';
					}
					$html .= $row;
				}
			}
		}
		echo $html;
	}
	?>
</ul>
<?php
//jimport('joomla.html.pagination');
