<?php
/**
 * MStat plugin for Joomla! 1.6/1.7/2.5
 * @license http://www.gnu.org/licenses/gpl.html GNU/GPL.
 * @by DtD Productions
 * @Copyright (C) 2011-2012 
  */
defined( '_JEXEC' ) or die( 'Restricted access' );

class  plgContentMStat extends JPlugin
{
	function plgContentMStat (& $subject) {
		parent::__construct($subject);
	}
	
	public function onContentAfterDisplay($context, &$article, &$params, $limitstart)
	{
		//Tracking Module
		$user = &JFactory::getUser();
		$session = &JFactory::getSession();
			
		$db =& JFactory::getDBO();
		$q  = 'INSERT INTO #__mstat (mstat_user,mstat_article,mstat_cat,mstat_session,mstat_ipaddr) ';
		$q .= 'VALUES ("'.$user->id.'","'.$article->id.'","'.$article->catid.'","'.$session->getId().'","'.$_SERVER['REMOTE_ADDR'].'")';
		$db->setQuery( $q ); 
		$db->query();
		
		return '';
	}
}


