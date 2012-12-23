<?php

//чтобы нельзя было запускать вне джумлы
 defined('_JEXEC') or die('Restricted access');

// Подключаем библеотеку представления Joomla
 jimport('joomla.application.component.view');

                                                 
//класс отображает форму для расчёта мощности кондиционера
//создаем свой класс потомок JController
 class CondpowerViewForm extends JView
 {

  function display($tpl = null)                       
  {
        
        /**
        * Получение результата расчетов  для поиска в Виртуемарте
        */     
        if(JRequest::getVar('calc_power_submit'))
        {
            $params = &JComponentHelper::getParams('com_condpower');
            $this->dop_field_id = $params->get('dop_field_id');
            $model = $this->getModel('form');
            $this->power = $model->getPower();
            $this->npower = $model->getNpower($this->dop_field_id,$this->power);
        }

        
	//отобразить представление
	parent::display($tpl); 

	JHTML::stylesheet( 'form.css', 'components/com_condpower/assets/' );
  }  

 }

?>