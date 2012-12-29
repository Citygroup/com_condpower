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
    private $_filter_parent;
    private $_filter_search;
    private $_filter_category;
    private $_filter_custom_fields;



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
//            var_dump($query);
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
         * Строим селект списка родителей
         * @return query
         */
        private function _build_query_parents()
        {
            $query = $this->_db->getQuery(true);
            $query->select('virtuemart_custom_id');
            $query->select('custom_title');
            $query->from('#__virtuemart_customs');
            $query->where('field_type = "P"');
            return $query;
        }

        /**
         * Вывод списка родителей в дополнительных полях Виртуемарта
         * @return type
         */
	public function getParents()
        {
                $query = $this->_build_query_parents();
                $this->_db->setQuery((string)$query);
                return $this->_db->loadObjectList();
        }
        /**
         * Фильтры
         */
        function _buildQueryWhere()
        {
            $filter_search = $this->getFilter_search();
            $filter_category = $this->getFilter_category();
            // Prepare the WHERE clause
            $where = array();
            // Фильтр по названию
            if ( $filter_search)
            {
                $where[] = 'ru.'.$this->_db->nameQuote('product_name').' LIKE "'.$filter_search.'%"';
            }
            // Фильтр по категории товара
            if ( $filter_category)
            {
                $where[] = 'cat.'.$this->_db->nameQuote('virtuemart_category_id').' = '.$filter_category;
            }
            return $where;
        }
        /**
         * Получение значения для фильтра поиска по названию
         *  @return str
         */
        public function getFilter_search()
        {
            if(!$this->_filter_search)
            {
                $mainframe = &JFactory::getApplication();
                $this->_filter_search = $mainframe->getUserStateFromRequest(
                                'com_condpower'.'filter_search',
                                'filter_search','');
                if ($this->_filter_search)
                {
                    $mainframe->setUserState( 'com_condpower'.'filter_search', $this->_filter_search);
                }
            }
            return $this->_filter_search;
        }
        /**
         * Получение значения для фильтра поиска по категориям товаров
         *  @return str
         */
        public function getFilter_category()
        {
            if(!$this->_filter_category)
            {
                $mainframe = &JFactory::getApplication();
                $this->_filter_category = $mainframe->getUserStateFromRequest(
                                'com_condpower'.'filter_category',
                                'filter_category','');
                if ($this->_filter_category)
                {
                    $mainframe->setUserState( 'com_condpower'.'filter_category', $this->_filter_category);
                }
            }
            return $this->_filter_category;
        }
        /**
         * Получение значения для фильтра по пользовательским полям
         *  @return str
         */
        public function getFilter_custom_fields()
        {
            if(!$this->_filter_custom_fields)
            {
                $mainframe = &JFactory::getApplication();
                $this->_filter_custom_fields = $mainframe->getUserStateFromRequest(
                                'com_condpower'.'filter_custom_fields',
                                'filter_custom_fields',array());
                if ($this->_filter_custom_fields)
                {
                    $mainframe->setUserState( 'com_condpower'.'filter_custom_fields', $this->_filter_custom_fields);
                }
            }
            return $this->_filter_custom_fields;
        }
        /**
         * Получение первого родителя полей пользователя для селекта
         *  @return int
         */
        public function getFilter_parent()
        {
            if(!$this->_filter_parent)
            {
                $mainframe = &JFactory::getApplication();
                $this->_filter_parent = $mainframe->getUserStateFromRequest(
                                    'com_condpower'.'filter_parent',
                                    'filter_parent','');
                if ( !$this->_filter_parent)
                {
                    $query = $this->_build_query_parents();
                    $this->_db->setQuery((string)$query);
                    $this->_filter_parent = $this->_db->loadResult();
                }
                $mainframe->setUserState('com_condpower'.'filter_parent', $this->_filter_parent);
            }
            return $this->_filter_parent;
        }
        /**
         * Получение списка полей пользователя родителя
         *  @return int
         */
        public function getCustom_fields()
        {
            $query = $this->_db->getQuery(true);
            $query->select('virtuemart_custom_id');
            $query->select('custom_title');
            $query->from('#__virtuemart_customs');
            $query->where('`custom_parent_id` = '.$this->getFilter_parent());
            $this->_db->setQuery((string)$query);
            return $this->_db->loadObjectList();

        }

        /**
         * Готовим часть селекта, отвечающего за выборку значений полй пользователя Виртуемарта2
         */
        function _buildQuerySelect($c)
        {
            
            $select = $join = array();
            // Определяем ИД родителя
            $filter_parent = $this->getFilter_parent();
            // Выбираем детей
            $query = $this->_db->getQuery(true);
            $query->select('virtuemart_custom_id');
            $query->from('#__virtuemart_customs ');
            $query->where('custom_parent_id = '.$filter_parent);
            // Если установлен фильтр по полям пользователя
            $filter_custom_fields = $this->getFilter_custom_fields();
            if (count($filter_custom_fields)>0)
            {
                $query->where('virtuemart_custom_id IN ('.implode(',',$filter_custom_fields).')');
            }
            $this->_db->setQuery((string)$query);
            $cids = $this->_db->LoadResultArray();
            // Сама часть селекта
            foreach($cids as $cid)
            {
                $join[] = ' LEFT JOIN '.$c.' AS c'.$cid.' ON (`cat`.`virtuemart_product_id` = `c'.$cid.'`.`virtuemart_product_id`)'.
                        ' AND `c'.$cid.'`.`virtuemart_custom_id` = '.$cid;
                $select[] = '`c'.$cid.'`.'.$this->_db->nameQuote('intvalue').' AS intvalue_'.$cid;
            }
            return array($select,$join);
        }
}
