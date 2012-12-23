<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * Condpower component helper.
 */
abstract class CondpowerHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('COM_CONDPOWER_SUBMENU_MESSAGES'), 'index.php?option=com_condpower', $submenu == 'messages');
		JSubMenuHelper::addEntry(JText::_('COM_CONDPOWER_SUBMENU_VMCATS'), 'index.php?option=com_condpower&view=vmcats', $submenu == 'vmcats');
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-condpower {background-image: url(../media/com_condpower/images/tux-48x48.png);}');
		if ($submenu == 'vmcats')
		{
			$document->setTitle(JText::_('COM_CONDPOWER_ADMINISTRATION_VMCATS'));
		}
	}
	/**
	 * Get the actions
	 */
	public static function getActions($messageId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
 
		if (empty($messageId)) {
			$assetName = 'com_condpower';
		}
		else {
			$assetName = 'com_condpower.message.'.(int) $messageId;
		}
 
		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete'
		);
 
		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}
 
		return $result;
	}
}
