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
            $mainframe = &JFactory::getApplication();
		// Get data from the model
		$this->items = $this->get('Items');
		$this->_categories = $this->get('Vcategories');
		$this->_parents = $this->get('Parents');
<<<<<<< HEAD
		$this->pagination = $this->get('Pagination');
                $this->filter_search = $this->get('Filter_search');
                $this->filter_custom_fields = $this->get('Filter_custom_fields');
                $filter_category = $this->get('Filter_category');
                $filter_parent = $this->get('Filter_parent');
		$this->custom_fields = $this->get('Custom_fields');
=======
		$pagination = $this->get('Pagination');

                $filter_search = $mainframe->getUserStateFromRequest(
                                    'com_condpower'.'filter_search',
                                    'filter_search','');
                $filter_category = $mainframe->getUserStateFromRequest(
                                    'com_condpower'.'filter_category',
                                    'filter_category','');
                $filter_parent = $mainframe->getUserStateFromRequest(
                                    'com_condpower'.'filter_parent',
                                    'filter_parent','');
                if(!$filter_parent)
                {
                    $filter_parent = $this->get('Filter_parent');
                }
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
                $this->lists['search'] = $filter_search;
		$this->items = $items;
>>>>>>> 1f36548ef43ba4622ea7870cc6db2525f7584fce
                $this->category_selecting = $this->_category_selecting(
                    'filter_category',
                    array('onchange'=>'document.adminForm.submit()'),
                    $filter_category,
                    'filter_category'
                );
                $this->parent_selecting = $this->_parent_selecting(
                    'filter_parent',
                    array('onchange'=>'document.adminForm.submit()'),
                    $filter_parent,
                    'filter_parent'
                );
 
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
		if ($canDo->get('core.admin')) 
		{
                    JToolBarHelper::divider();
                    JToolBarHelper::custom('condpowers.export_csv', 'upload', '', JText::_('COM_CONDPOWER_MANAGER_EXPORT'), TRUE);
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
                        , JText::_('SELECT_CATEGORY')
                );
                foreach ($this->_categories as $category)
                {
//                    var_dump($category);exit;
                    $state[] = JHTML::_('select.option'
                            , $category->catid
                            , JText::_($category->name)
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
        /**
         * Выводим список родителей в дополнительных полях
         */
        private function _parent_selecting($name, $attribs = null, $selected = NULL, $idtag = false)
        {
            if ($this->_parents)
            {
                $state = array();
                $state[] = JHTML::_('select.option'
                        , 0
                        , JText::_('SELECT_PARENT')
                );
                foreach ($this->_parents as $parent)
                {
//                    var_dump($category);exit;
                    $state[] = JHTML::_('select.option'
                            , $parent->virtuemart_custom_id
                            , JText::_($parent->custom_title)
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