<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * Condpower Model
 */
class CondpowerModelVmcat extends JModelAdmin
{
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_condpower.message.'.((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Condpower', $prefix = 'CondpowerTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_condpower.vmcat', 'vmcat', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	Script files
	 */
	public function getScript() 
	{
		return 'administrator/components/com_condpower/models/forms/condpower.js';
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_condpower.edit.vmcat.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	/**
	 * Method to delete rows from table of ID categories.
         * Recursive delete rows from #__virtuemart_product_custom_plg_param
	 *
	 * @param	array of ID virtuemart categories with custom params.
	 * @return	bool and error string.
	 * @since	0.0.1
         * @author	Konstantin Ovcharenko
	 */
        public function delete($cids)
        {
            $row = & $this->getTable();
            $msg = '';
            if (count($cids)) {
                foreach ($cids as $cid) {
                    if (!$row->load($cid))
                    {
                        return array(FALSE,$row->getErrorMsg());
                    }
                    else
                    {
                        //Id category
                        $cat_id = $row->catid;
                        list($del_custom_fields_ok, $del_custom_fields_msg) = $this->_del_custom_fields($cat_id);
                        $msg .= $del_custom_fields_msg.' ';
                        if ($del_custom_fields_ok)
                        {
                            if (!$row->delete())
                            {
                                return array(FALSE,$msg.$row->getErrorMsg());
                            }
                        }
                        else
                        {
                            return array(FALSE,$msg);
                        }
                    }
                }
            }
            return array(TRUE,$msg);
        }
	/**
	 * Method to delete rows from #__virtuemart_product_custom_plg_param
	 *
	 * @param	int ID category of virtuemart products with custom params.
	 * @return	bool and error string.
	 * @since	0.0.1
	 * @author	Konstantin Ovcharenko
	 */
        private function _del_custom_fields($virtuemart_category_id)
        {
            $msg = '';
            $return = TRUE;
            $this->_db = $this->_db;
            $query = $this->_db->getQuery(true);
            $query->select('#__virtuemart_product_custom_plg_param.id');
            $query->from('#__virtuemart_product_custom_plg_param');
            $query->leftJoin('#__virtuemart_product_categories'.
                                ' ON #__virtuemart_product_categories.virtuemart_product_id'.
                                ' = #__virtuemart_product_custom_plg_param.virtuemart_product_id');
            $query->where('#__virtuemart_product_categories.virtuemart_category_id = '.$virtuemart_category_id);
            $this->_db->setQuery((string)$query);
            $ids = $this->_db->loadResultArray();
            if ($ids)
            {
                $row = & $this->getTable('vmcat');
                foreach($ids as $id)
                {
                    if (!$row->delete($id))
                    {
                        $return = FALSE;
                        $msg .= $row->getErrorMsg();
                    }
                }
            }
            else
            {
                $return = TRUE;
                $msg .= JTEXT::_('COM_CONDPOWER_MODEL_VMCAT_EMPTY_CATEGORY_PRODUCTS').' Id='.$virtuemart_category_id;
            }
            return array($return,$msg);
        }
	/**
	 * Method to add rows to #__virtuemart_product_custom_plg_param
	 *
	 * @param	int ID category of virtuemart products with custom params.
	 * @return	bool and error string.
	 * @since	0.0.1
	 * @author	Konstantin Ovcharenko
	 */
        public function add_custom_fields($virtuemart_category_id)
        {
            $params = &JComponentHelper::getParams($this->option);
            $virtuemart_custom_id = $params->get('dop_field_id');
            $this->_db = $this->_db;
            $query = $this->_db->getQuery(true);
            $query->select('#__virtuemart_products.virtuemart_product_id');
            $query->from('#__virtuemart_products');
            $query->from('#__virtuemart_product_categories');
            $query->where('#__virtuemart_product_categories.virtuemart_product_id = #__virtuemart_products.virtuemart_product_id');
            $query->where('#__virtuemart_product_categories.virtuemart_category_id = '.$virtuemart_category_id);
            $this->_db->setQuery((string)$query);
            $id_products = $this->_db->loadResultArray();
            
            foreach($id_products as $virtuemart_product_id)
            {
                $data['virtuemart_product_id'] = $virtuemart_product_id;
                $data['virtuemart_custom_id'] = $virtuemart_custom_id;
                $id = $this->_find_id($virtuemart_product_id);
                if ($id === 0)
                {
                    $this->_save($data);
                }
            }
        }
        
        private function _find_id($virtuemart_product_id)
        {
            $this->_db = $this->_db;
            $query = $this->_db->getQuery(true);
            $query->select('id');
            $query->from('#__virtuemart_product_custom_plg_param');
            $query->where('virtuemart_product_id = '.$virtuemart_product_id);
            $this->_db->setQuery((string)$query);
            return (int)$this->_db->loadResult();
        }
        private function _save($data)
        {
            $table = $this->getTable('vmcat');
            // Bind the data.
            if (!$table->bind($data))
            {
                    $this->setError($table->getError());
                    return false;
            }
            // Prepare the row for saving
            $this->prepareTable($table);

            // Check the data.
            if (!$table->check())
            {
                    $this->setError($table->getError());
                    return false;
            }

            // Store the data.
            if (!$table->store())
            {
                    $this->setError($table->getError());
                    return false;
            }
            return TRUE;
    }
}
