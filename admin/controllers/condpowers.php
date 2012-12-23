<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Condpowers Controller
 */
class CondpowerControllerCondpowers extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Condpower', $prefix = 'CondpowerModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

        public function export_csv()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
            $cids = JRequest::getVar('cid', array(), '', 'array');
            $model = $this->getModel('Vmcat');
            list($resuls,$msg) = $model->export_csv($cids);
            $this->setMessage($msg);
            $this->setRedirect(
                JRoute::_(
                        'index.php?option=' . $this->option.'&view=condpowers', false
                )
            );
           
        }
        public function import_csv()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

            $cids = JRequest::getVar('cid', array(), '', 'array');
            $model = $this->getModel('Vmcat');
            list($resuls,$msg) = $model->import_csv($cids);
            $this->setMessage($msg);
            $this->setRedirect(
                JRoute::_(
                        'index.php?option=' . $this->option.'&view=condpowers', false
                )
            );
        }

}
