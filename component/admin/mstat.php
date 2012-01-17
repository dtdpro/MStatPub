<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_mstat')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

//icon
//$document = JFactory::getDocument();
//$document->addStyleDeclaration('.icon-48-ContinuEd {background-image: url(../media/com_continued/images/continued-48x48.png);}');
//$document->addStyleDeclaration('.icon-48-continued {background-image: url(../media/com_continued/images/continued-48x48.png);}');


// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by vidrev
$controller = JController::getInstance('MStat');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

?>
