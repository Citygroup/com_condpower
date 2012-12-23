<?php
               
//чтобы нельзя было запускать вне джумлы
 defined('_JEXEC') or die('Restricted access');

// Подключаем библеотеку контроллера Joomla
 jimport('joomla.application.component.controller');



//создаем свой класс потомок JController
 class CondpowerController extends JController
 {

//задача по умолчанию
  function display()
  {                                                                       
	parent::display();
  }
    function calc()
    {
        $params = &JComponentHelper::getParams('com_condpower');
        $dop_field_id = $params->get('dop_field_id');
        $model = $this->getModel('form');
        $power = $model->getPower();
        $npower = $model->getNpower($dop_field_id,$power);
//        JRequest::setVar('option', 'com_virtuemart');
//        JRequest::setVar('search', 'true');
//        JRequest::setVar('view', 'category');
//        JRequest::setVar('custom_parent_id', $dop_field_id);
//        JRequest::setVar('cpi[]', $dop_field_id);
        JRequest::setVar('limitstart', '0');
        JRequest::setVar('cv'.$dop_field_id.'[]', $npower);
//        $this->setRedirect('index.php?option=com_virtuemart&view=category');
        $this->setRedirect(JRoute::_('index.php?option=com_virtuemart&view=category&search=true&custom_parent_id='.$dop_field_id.'&cpi[]='.$dop_field_id.'&limitstart=0&cv'.$dop_field_id.'[]='.$npower, false));

//        var_dump(JRoute::_('index.php?option=com_virtuemart&view=category'));exit;
    }

 }

?>