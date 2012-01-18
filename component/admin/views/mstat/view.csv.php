<?php
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MStatViewMStat extends JView
{
	function display($tpl = 'csv')
	{
		$model = $this->getModel();
		$this->items = $model->getItemsCSV();
		
		parent::display($tpl);
	}
}
