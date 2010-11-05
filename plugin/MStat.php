<?php
/**
 * MStat plugin for Joomla! 1.5
 * @license http://www.gnu.org/licenses/gpl.html GNU/GPL.
 * @by DtD Productions
 * @Copyright (C) 2008 
  */
defined( '_JEXEC' ) or die( 'Restricted access' );

class  plgContentMStat extends JPlugin
{
	function plgContentMStat (& $subject) {
		parent::__construct($subject);
	}
}

$mainframe->registerEvent( 'onAfterDisplayContent', 'MStat' );

function MStat(&$row, &$params) {
	
	//Tracking Module
	$view = JRequest::getVar( 'view' );
	$user = &JFactory::getUser();
	$session = &JFactory::getSession();
		
	if ($option = 'com_content' && ($view == 'article' || $view == 'category' || $view == 'section' || $view == 'archive')) {
		$db =& JFactory::getDBO();
		$query = 'INSERT INTO #__mstat (mstat_user,mstat_article,mstat_cat,mstat_session) VALUES ("'.$user->id.'","'.$row->id.'","'.$row->catid.'","'.$session->getId().'")';
		$db->setQuery( $query ); 
		$db->query();
	}
	
}


?>
