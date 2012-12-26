<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_condpower'); ?>" method="post" name="adminForm">
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

	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
