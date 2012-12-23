<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5%">
		<?php echo JText::_('Id'); ?>
	</th>
	<th width="10%">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th width="10%">
		<?php echo JText::_('COM_CONDPOWER_CATEGORY_ID'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_CONDPOWER_CATEGORY_NAME'); ?>
	</th>
</tr>
