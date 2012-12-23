<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Condpowers View
 */
class CondpowerViewCondpowers extends JView
{
	/**
	 * Condpowers view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = CondpowerHelper::getActions();
		JToolBarHelper::title(JText::_('COM_CONDPOWER_MANAGER_CONDPOWERS'), 'condpower');
//		if ($canDo->get('core.create')) 
//		{
//			JToolBarHelper::addNew('condpower.add', 'JTOOLBAR_NEW');
//		}
//		if ($canDo->get('core.edit')) 
//		{
//			JToolBarHelper::editList('condpower.edit', 'JTOOLBAR_EDIT');
//		}
//		if ($canDo->get('core.delete')) 
//		{
//			JToolBarHelper::deleteList('', 'condpowers.delete', 'JTOOLBAR_DELETE');
//		}
		if ($canDo->get('core.admin')) 
		{
                    JToolBarHelper::divider();
                    JToolBarHelper::custom('condpowers.export_csv', 'upload', '', JText::_('COM_CONDPOWER_MANAGER_EXPORT'), false);
                    JToolBarHelper::custom('condpowers.import_csv', 'back', '', JText::_('COM_CONDPOWER_MANAGER_IMPORT'), false);
                    JToolBarHelper::divider();
                    JToolBarHelper::preferences('com_condpower');
		}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_CONDPOWER_ADMINISTRATION'));
	}
}
