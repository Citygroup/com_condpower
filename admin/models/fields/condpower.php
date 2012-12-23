<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Condpower Form Field class for the Condpower component
 */
class JFormFieldCondpower extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Condpower';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = new JDatabaseQuery;
		$query->select('#__condpower.id as id,name,#__categories.title as category,catid');
		$query->from('#__condpower');
		$query->leftJoin('#__categories on catid=#__categories.id');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = JHtml::_('select.option', $message->id, $message->name . ($message->catid ? ' (' . $message->category . ')' : ''));
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
