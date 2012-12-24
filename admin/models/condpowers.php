<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * CondpowerList Model
 */
class CondpowerModelCondpowers extends JModelList
{
    
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
            $db = &$this->_db;
            $select[] = 'c.'.$db->nameQuote('id');
            $select[] = 'c.'.$db->nameQuote('virtuemart_product_id');
            $select[] = 'c.'.$db->nameQuote('virtuemart_custom_id');
            $select[] = 'c.'.$db->nameQuote('intvalue');
            $select[] = 'ru.'.$db->nameQuote('product_name');
            $from[] = $db->nameQuote('#__virtuemart_product_custom_plg_param').' AS c';
            $from[] = $db->nameQuote('#__virtuemart_products').' AS p';
            $from[] = $db->nameQuote('#__virtuemart_products_ru_ru').' AS ru';
            $where[] = 'c.'.$db->nameQuote('virtuemart_product_id').' = '.
                       'p.'.$db->nameQuote('virtuemart_product_id');
            $where[] = 'ru.'.$db->nameQuote('virtuemart_product_id').' = '.
                       'p.'.$db->nameQuote('virtuemart_product_id');
            $query = 'SELECT '.implode(',',$select);
            $query .= ' FROM '.implode(',',$from);
            $query .= ' WHERE '.implode(' AND ',$where);
            return $query;
	}
	protected function getCaegory()
        {
            $query = $this->_db->getQuery(true);
            $query->select('#__condpower.id');
            $query->select('#__condpower.nm');
            $query->from('#__condpower');
            $db->setQuery((string)$query);
            return $db->loadResultArray();
        }
}
