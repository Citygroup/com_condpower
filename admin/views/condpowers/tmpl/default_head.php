<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="10px">
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_PRODUCT_ID'); ?>
	</th>
	<th width="5px">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th width="30%">
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_VALUE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_PRODUCT_SKU'); ?>
	</th>
</tr>
