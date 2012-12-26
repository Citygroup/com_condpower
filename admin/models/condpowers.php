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
            $cat = $db->nameQuote('#__virtuemart_product_categories');
            $c = $db->nameQuote('#__virtuemart_product_custom_plg_param');
            $p = $db->nameQuote('#__virtuemart_products');
            $ru = $db->nameQuote('#__virtuemart_products_ru_ru');
            $cond = $db->nameQuote('#__condpower');
            $where = $this->_buildQueryWhere();
            $query = 'SELECT '.implode(',',$select);
            $query .= ' FROM '.$cat.' AS cat';
            $query .= ' JOIN '.$cond.' AS cond ON (`cat`.`virtuemart_category_id` = `cond`.`catid`)';
            $query .= ' JOIN '.$p.' AS p ON (`cat`.`virtuemart_product_id` = `p`.`virtuemart_product_id`)';
            $query .= ' LEFT JOIN '.$c.' AS c ON (`cat`.`virtuemart_product_id` = `c`.`virtuemart_product_id`)';
            $query .= ' LEFT JOIN '.$ru.' AS ru ON (`cat`.`virtuemart_product_id` = `ru`.`virtuemart_product_id`)';
            if($where)
            {
                $query .= ' WHERE '.implode(' AND ',$where);
            }
//            var_dump($query);
            return $query;
	}
	public function getVcategories()
        {
            $query = $this->_db->getQuery(true);
            $query->select('#__condpower.catid');
            $query->select('#__condpower.name');
            $query->from('#__condpower');
            $this->_db->setQuery((string)$query);
//            var_dump($this->_db->loadObjectList());
//            exit;
            return $this->_db->loadObjectList();
        }
        /**
         * Фильтры
         */
        function _buildQueryWhere()
        {
            $mainframe = &JFactory::getApplication();
            $filter_search = $mainframe->getUserStateFromRequest(
                                'com_condpower'.'filter_search',
                                'filter_search','');
            // Training filtering
            $filter_category = $mainframe->getUserStateFromRequest(
                                'com_condpower'.'filter_category',
                                'filter_category','');
            // Prepare the WHERE clause
            $where = array();
            // Determine published state
            if ( $filter_search)
            {
                $mainframe->setUserState( 'com_condpower'.'filter_search', $filter_search );
                $where[] = 'ru.'.$this->_db->nameQuote('product_name').' LIKE "'.$filter_search.'%"';
            }
            if ( $filter_category)
            {
                $mainframe->setUserState( 'com_condpower'.'filter_category', $filter_category );
                $where[] = 'cat.'.$this->_db->nameQuote('virtuemart_category_id').' = '.$filter_category;
            }
            return $where;
        }
}
