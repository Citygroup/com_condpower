<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.model');
/**
 * Rest model class
 *
 * @package		Joomla.Site
 * @subpackage	com_condpower
 * @since		1.6
 */
class CondpowerModelForm extends JModel
{
	/**
	 * Method to get the power.
	 *
	 * @return	string
	 * @since	1.6
	 */
	public function getPower()
	{
            //НАЗНАЧЕНИЕ ПОМЕЩЕНИЯ
            $this->type = JRequest::getInt('type');
            //ПЛОЩАДЬ ПОМЕЩЕНИЯ
            $this->square = JRequest::getInt('square');
            if ($this->square == 0) $this->square = null;
            //ВЫСОТА ПОТОЛКА
            $this->height = JRequest::getFloat('height');
            if ($this->height == 0.0) $this->height = null;
            //КОЛИЧЕСТВО ЧЕЛОВЕК В ПОМЕЩЕНИИ
            $this->people = JRequest::getFloat('people');
            if ($this->people == 0.0) $this->people = null;
            //ТЕПЛОВЫДЕЛЯЮЩЕЕ ОБОРУДОВАНИЕ В ПОМЕЩЕНИИ
            //компьютер
            $this->computer = JRequest::getBool('computer');
            if ($this->computer) {
                    $this->comp_num = JRequest::getInt('comp_num');
                    if ($this->comp_num == 0) $this->comp_num = 1;
            }
            //свч
            $this->svc = JRequest::getBool('svc');
            if ($this->svc) {
                    $this->svc_num = JRequest::getInt('svc_num');
                    if ($this->svc_num == 0) $this->svc_num = 1;
            }            
            //холодильник
            $this->ref = JRequest::getBool('ref');
            if ($this->ref) {
                    $this->ref_num = JRequest::getInt('ref_num');
                    if ($this->ref_num == 0) $this->ref_num = 1;
            }
            //ОРИЕНТАЦИЯ ОКНА
            $this->orient = JRequest::getInt('orient');
            //ШТОРЫ (ЖАЛЮЗИ)
            $this->galuzi = JRequest::getInt('galuzi');

            //расчёт тепла
            //примерный размер окон
            $Q1 = ($this->height*0.7)*(sqrt($this->square)*0.7);
            //тепло от окон в м.
            switch ($this->orient) {
                    case 1: $Q1=$Q1*85; break;
                    case 2: $Q1=$Q1*260; break;
                    case 3: $Q1=$Q1*580; break;
                    case 4: $Q1=$Q1*580; break;
            }
            if ($this->galuzi==1) $Q1=$Q1/1.4;
            //тепло от человека
            switch ($this->type) {
                    case 1: $Q2=$this->people*150; break;
                    case 2: $Q2=$this->people*125; break;
                    case 3: $Q2=$this->people*300; break;
            }
            //тепло от оборудования
            if ($this->computer) $Q3=$this->comp_num*350;
            if ($this->svc) $Q3=$Q3+$this->svc_num*800;
            if ($this->ref) $Q3=$Q3+$this->ref_num*500;
            //тепловыделение от перегородок
            $Q4 = $this->square*18+sqrt($this->square)*$this->height*27;
            //теплоёмкость воздуха
            $Q5 = ($this->square*$this->height)*6;
            $this->Q=$Q1+$Q2+$Q3+$Q4+$Q5;
            $this->Q=round($this->Q/100)/10;

		return $this->Q;
	}
        	/**
	 * Method to get the power.
	 *
	 * @return	int
	 * @since	1.6
	 */
        public function getNpower($id, $rpower)
        {
            $table = $this->_db->nameQuote('#__virtuemart_product_custom_plg_param');
            $field = $this->_db->nameQuote('intvalue');
            $where[] = $this->_db->nameQuote('virtuemart_custom_id').' = '.$id;
            $where[] = $this->_db->nameQuote('intvalue').' > '.$rpower;
            $query = 'SELECT MIN('.$field.')'.
                    ' FROM '.$table.
                    ' WHERE '.implode(' AND ', $where);
            $this->_db->setQuery($query);
            $result = $this->_db->loadResult();
            return round($result,2);
        }
}
