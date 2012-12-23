<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * Category Controller
 */
class CondpowerControllerVmcat extends JControllerForm
{
        public function save()
        {
            if(parent::save())
            {
                $jform = JRequest::getVar('jform', array(), '', 'array');
                $catid = $jform[catid];
                $model = $this->getModel('Vmcat');
                list($resuls,$msg) = $model->add_custom_fields($catid);
            }
        }
        public function delete()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

            $ids = JRequest::getVar('cid', array(), '', 'array');
            $model = $this->getModel('Vmcat');
            list($resuls,$msg) = $model->delete($ids);
            $this->setMessage($msg);
//            $this->setRedirect(JRoute::_('index.php?option=com_condpower&view=vmcats'), false);
            $this->setRedirect(
            JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_list
                    . $this->getRedirectToListAppend(), false
            )
    );
        }

}
