<?php
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MStatViewMStat extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'MStat Records' ), 'mstat' );
		$model = $this->getModel();
		$this->filtercat = $model->getState('filter_cat');
		$tbar =& JToolBar::getInstance('toolbar');
		JToolBarHelper::preferences('com_mstat');
		$tbar->appendButton('Link','archive','Export CSV','index.php?option=com_mstat&format=csv" target="_blank');
		
		$mstatConfig = JComponentHelper::getParams('com_mstat');
		$cfg = $mstatConfig->toObject();
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->startdate = $model->getState('startdate');
		$this->enddate = $model->getState('enddate');
		$this->filter_cat = $model->getState('filter_cat');
		$this->filter_group = $model->getState('filter.group');
		
		if ($cfg->continued) {
			$this->grouplist=$this->get('UserGroups');
		}
		
		parent::display($tpl);
	}
}
