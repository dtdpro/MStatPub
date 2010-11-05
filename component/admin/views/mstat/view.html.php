<?php
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MStatViewMStat extends JView
{
	function display($tpl = null)
	{
		$user = JRequest::getVar('filter_user');
		$session = JRequest::getVar('filter_session');
		$month = JRequest::getVar('filter_month');
		$year = JRequest::getVar('filter_year');
		$cat = JRequest::getVar('filter_cat');
		$article = JRequest::getVar('filter_article');
		JToolBarHelper::title(   JText::_( 'MStat Viewer' ), 'generic.png' );
		//JToolBarHelper::custom('csvme','archive','','CSV',false);
		JToolBarHelper::back('List All','index.php?option=com_mstat');
		$model = $this->getModel();

		$items		= & $this->get( 'Data');
		$pagination = & $this->get( 'Pagination' );
		$catlist = $model->getCatList();

		$this->assignRef('user',$user);
	    $this->assignRef('session',$session);
	    $this->assignRef('month',$month);
	    $this->assignRef('year',$year);
	    $this->assignRef('catlist',$catlist);
	    $this->assignRef('cat',$cat);
	    $this->assignRef('article',$article);
	    $this->assignRef('items',$items);
	    $this->assignRef('pagination',$pagination);

		parent::display($tpl);
	}
}
