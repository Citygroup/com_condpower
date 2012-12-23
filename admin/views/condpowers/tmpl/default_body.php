<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
            
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->virtuemart_product_id; ?>
		</td>
		<td>
			<?php echo $item->virtuemart_custom_id; ?>
		</td>
		<td>
			<?php echo $item->intvalue; ?>
		</td>
		<td>
			<?php echo $item->product_name; ?>
		</td>
	</tr>
<?php endforeach; ?>
