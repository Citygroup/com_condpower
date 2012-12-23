<?php     

//чтобы нельзя было запускать вне джумлы
 defined('_JEXEC') or die('Restricted access');

 //добавить контроллер
 require_once(JPATH_COMPONENT.DS.'controller.php');

 //создать объект контроллера
 $controller = new CondpowerController();

 //Обрабатываем запрос (task)
 $controller->execute(JRequest::getVar('task'));

 //Переадресуем, если установлено контроллером
 $controller->redirect();

?>