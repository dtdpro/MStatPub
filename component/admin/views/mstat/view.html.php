<?php
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MStatViewMStat extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'MStat Records' ), 'generic.png' );
		$model = $this->getModel();
		$this->filtercat = $model->getState('filter_cat');
		$tbar =& JToolBar::getInstance('toolbar');
		$tbar->appendButton('Link','archive','Export CSV','index.php?option=com_mstat&controller=mstat&task=csvme&format=raw');
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->startdate = $model->getState('startdate');
		$this->enddate = $model->getState('enddate');
		$this->filter_cat = $model->getState('filter_cat');
		
		parent::display($tpl);
	}
}
