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
            $c = $db->nameQuote('#__virtuemart_product_custom_plg_param');
            list($select,$join) = $this->_buildQuerySelect($c);
            $select[] = 'p.'.$db->nameQuote('virtuemart_product_id');
//            $select[] = 'c.'.$db->nameQuote('virtuemart_custom_id');
            $select[] = 'ru.'.$db->nameQuote('product_name');
            $cat = $db->nameQuote('#__virtuemart_product_categories');
            $p = $db->nameQuote('#__virtuemart_products');
            $ru = $db->nameQuote('#__virtuemart_products_ru_ru');
            $cond = $db->nameQuote('#__condpower');
            $where = $this->_buildQueryWhere();
            $query = 'SELECT '.implode(',',$select);
            $query .= ' FROM '.$cat.' AS cat';
            $query .= ' JOIN '.$cond.' AS cond ON (`cat`.`virtuemart_category_id` = `cond`.`catid`)';
            $query .= ' JOIN '.$p.' AS p ON (`cat`.`virtuemart_product_id` = `p`.`virtuemart_product_id`)';
            
            $query .= ' LEFT JOIN '.$ru.' AS ru ON (`cat`.`virtuemart_product_id` = `ru`.`virtuemart_product_id`)';
            $query .= implode(' ',$join);
            if($where)
            {
                $query .= ' WHERE '.implode(' AND ',$where);
            }
            var_dump($query);
            return $query;
	}
        /**
         * Вывод списка категорий компонента condpower
         * @return objects list
         */
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
         * Вывод списка родителей в дополнительных полях Виртуемарта
         * @return type
         */
	public function getParents()
        {
            $query = $this->_db->getQuery(true);
            $query->select('virtuemart_custom_id');
            $query->select('custom_title');
            $query->from('#__virtuemart_customs');
            $query->where('field_type = "P"');
            $this->_db->setQuery((string)$query);
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
        /**
         * Добавляем в селект дополнительные поля
         */
        function _buildQuerySelect($c)
        {
            $mainframe = &JFactory::getApplication();
            $filter_parent = $mainframe->getUserStateFromRequest(
                                'com_condpower'.'filter_parent',
                                'filter_parent','');
            $select = $from = array();
            if ( $filter_parent)
            {
                $mainframe->setUserState( 'com_condpower'.'filter_parent', $filter_parent );
                $query = $this->_db->getQuery(true);
                $query->select('virtuemart_custom_id');
                $query->from('#__virtuemart_customs ');
                $query->where('custom_parent_id = '.$filter_parent);
                $this->_db->setQuery((string)$query);
                $cids = $this->_db->LoadResultArray();
                foreach($cids as $cid)
                {
                    $join[] = ' LEFT JOIN '.$c.' AS c'.$cid.' ON (`cat`.`virtuemart_product_id` = `c'.$cid.'`.`virtuemart_product_id`)'.
                            ' AND `c'.$cid.'`.`virtuemart_custom_id` = '.$cid;
                    $select[] = '`c'.$cid.'`.'.$this->_db->nameQuote('intvalue');
                }
            }
            return array($select,$join);
        }
}
