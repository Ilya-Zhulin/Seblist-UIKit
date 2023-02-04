<?php
/*
 * File table.php is programmed
 * specially for CRM by
 * Ilya A.Zhulin <ilya.zhulin@hotmail.com> 2022
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

$app						 = Factory::getApplication();
$html						 = '';
$items						 = $cck->getItems();
$fieldnames					 = $cck->getFields('uk-grid', '', false);
$multiple					 = (count($fieldnames) > 1) ? true : false;
$count						 = count($items);
$uk_table_table_class		 = trim($cck->getStyleParam('uk_table_table_class', ''));
$uk_table_table_class		 = $uk_table_table_class ? ' class="' . $uk_table_table_class . '"' : '';
$uk_table_table_attribute	 = trim($cck->getStyleParam('uk_table_table_attribute', ''));
$uk_table_table_attribute	 = $uk_table_table_attribute ? $uk_table_table_attribute : '';

$uk_table_tr_class			 = trim($cck->getStyleParam('uk_table_tr_class', ''));
$uk_table_tr_class			 = $uk_table_tr_class ? ' class="' . $uk_table_tr_class . '"' : '';
$uk_table_tr_attribute		 = trim($cck->getStyleParam('uk_table_tr_attribute', ''));
$uk_table_tr_attribute		 = $uk_table_tr_attribute ? $uk_table_tr_attribute : '';
$uk_table_th				 = trim($cck->getStyleParam('uk_table_th', '0'));
$uk_table_responsive_table	 = trim($cck->getStyleParam('uk_table_responsive_table', '0'));
$fields						 = [];
?>
<?php
if ($uk_table_responsive_table > 0) {
	?>
	<div class="uk-overflow-auto">
		<?php
	}
	?>
	<table<?php echo $uk_table_table_class . $uk_table_table_attribute; ?>>
		<?php
		if ($uk_table_th > 0) {
			?>
			<thead>
				<tr>
					<?php
					if ($count) {
						$first_key = array_key_first($items);
						foreach ($items[$first_key]->fields as $item) {
							echo '<th>' . $item->label . '</th>';
							$fields[] = $item;
						}
					}
					?>
				</tr>
			</thead>
			<?php
		} else {
			if ($count) {
				$first_key = array_key_first($items);
				foreach ($items[$first_key]->fields as $item) {
					$fields[] = $item;
				}
			}
		}
		?>
		<tbody>
			<?php
			if ($count) {
				foreach ($items as $pk => $item) {
					$row = '<tr' . $uk_table_tr_class . '' . $uk_table_tr_attribute . '>';
					foreach ($fields as $fieldname) {
//					jbdump($fieldname->name, 0);
						$content = $item->renderField($fieldname->name);
						if ($item->getMarkup($fieldname->name) != 'none' && ( $multiple || $item->getMarkup_Class($fieldname->name) )) {
							$row .= '<td class="uk-clearfix' . $item->getMarkup_Class($fieldname->name) . '">' . $content . '</td>';
						} else {
							$row .= '<td>' . $content . '</td>';
						}
					}
					$row	 .= '</tr>';
					$html	 .= $row;
					?>
					<?php
				}
			}
			echo $html;
			?>

		</tbody>
	</table>
	<?php
	if ($uk_table_responsive_table > 0) {
		?>
	</div>
	<?php
}