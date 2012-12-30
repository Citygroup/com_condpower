<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<style type="text/css">
    #com_condpower tr{padding: 0; margin: 0}
    #com_condpower td{padding: 0 2px; margin: 0}
    #com_condpower th{padding: 0; margin: 0}
</style>
<div id="com_condpower">
<form enctype="multipart/form-data" name="adminForm" action="<?php echo JRoute::_('index.php?option=com_condpower'); ?>" method="post" name="adminForm">
    <table>
    <tr>
        <td align="left" width="100%">
            <?php echo JText::_('Filter'); ?>:
            <input type="text" name="filter_search" id="search"
            value="<?php echo $this->filter_search;?>"
            class="text_area">
            <button onclick="this.form.submit();">
            <?php echo JText::_('Search'); ?>
            </button>
            <button onclick="document.adminForm.filter_search.value='';this.form.submit();">
            <?php echo JText::_('Reset'); ?>
            </button>
        </td>
        <td nowrap="nowrap">
            <?php
                foreach($this->custom_fields as $field)
                {
                    $checked = isset($this->filter_custom_fields[$field->virtuemart_custom_id]);
                    $checked = $checked?'checked="checked"':'';
                    echo '<input type="checkbox"'.
                            ' id="filter_custom_fields_'.$field->virtuemart_custom_id.'"'.
                            ' name="filter_custom_fields['.$field->virtuemart_custom_id.']"'.
                            ' value="'.$field->virtuemart_custom_id.'"'.
                            ' onclick="this.form.submit()"'.
                            $checked.
                            '/>'.
                            '<label for="filter_custom_fields_'.$field->virtuemart_custom_id.'">'.$field->custom_title.'</label>'.
                            '<br/>'
                    ;
                }
            ?>
        </td>
        <td nowrap="nowrap">
            <?=$this->category_selecting?>
        </td>
        <td nowrap="nowrap">
            <?=$this->parent_selecting?>
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
                <input type="file" id="import_file_upload" 
                       name="file_upload" 
                       style="display: none" 
                       onchange="Joomla.submitform('condpowers.import_csv');"
                />
	</div>
</form>
</div>