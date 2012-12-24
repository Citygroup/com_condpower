<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<table>
    <tr>
        <td align="left" width="100%">
            <?php echo JText::_('Filter'); ?>:
            <input type="text" name="filter_search" id="search"
            value="<?php echo $this->lists['search'];?>"
            class="text_area">
            <button onclick="this.form.submit();">
            <?php echo JText::_('Search'); ?>
            </button>
            <button onclick="this.form.submit();">
            <?php echo JText::_('Reset'); ?>
            </button>
        </td>
        <td nowrap="nowrap">
            <?=$this->category_selecting?>
        </td>
    </tr>
</table>

<tr>
	<th width="5%">
		<?php echo JText::_('Id'); ?>
	</th>
	<th width="10%">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th width="10%">
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_PRODUCT_ID'); ?>
	</th>
	<th width="10%">
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_CUSTOM_ID'); ?>
	</th>
	<th width="10%">
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_VALUE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_CONDPOWER_CONDPOWER_PRODUCT_SKU'); ?>
	</th>
</tr>
