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
    private $_categories;
	/**
	 * Condpowers view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$this->_categories = $this->get('Categories');
		$pagination = $this->get('Pagination');

                $filter_search = $mainframe->getUserStateFromRequest(
                                    $option.'filter_search',
                                    'filter_search_date','');
                // Training filtering
                $filter_category = $mainframe->getUserStateFromRequest(
                                    $option.'filter_category',
                                    'filter_category','');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
                $this->category_selecting = $this->_category_selecting(
                    'filter_category',
                    array('onchange'=>'document.adminForm.submit()'),
                    $filter_category,
                    'filter_category'
                );
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
        /**
         * Выводим список категорий
         */
        private function _category_selecting($name, $attribs = null, $selected = NULL, $idtag = false)
        {
            if ($this->_categories)
            {
                $state = array();
                $state[] = JHTML::_('select.option'
                        , 0
                        , JText::_('SELECT_CLIENT')
                );
                foreach ($this->_categories as $category)
                {
                    $state[] = JHTML::_('select.option'
                            , $category->id
                            , JText::_($category->nm)
                    );
                }
                return JHTML::_('select.genericlist'
                                , $state
                                , $name
                                , $attribs
                                , 'value'
                                , 'text'
                                , $selected
                                , $idtag
                                , false );
            }
            return '';
         }

}