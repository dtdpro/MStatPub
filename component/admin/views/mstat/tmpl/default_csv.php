<?php
defined('_JEXEC') or die('Restricted access'); 

jimport( 'joomla.filesystem.file' );
$mstatConfig = JComponentHelper::getParams('com_mstat');
$cfg = $mstatConfig->toObject();
$path = JPATH_SITE.'/cache/';
$filename  =  'MStat_Report' . '-' . date("Y-m-d").'.csv';
$model = $this->getModel('mstat');
$items = $model->getItemsCSV();
$contents = '';	
$contents .= "\"Article\",\"Category\",\"When\",\"Who\",\"Email\",";
if ($cfg->continued) {
	$contents .= "\"Group\",";
}
$contents .= "\"Session\",\"IP Address\"\n";
for ($i=0, $n=count( $this->items ); $i < $n; $i++)
{
	$row = &$this->items[$i];
	if ($row->mstat_user == 0) $row->name='Guest';
	if (!$row->sctitle) $row->sctitle = 'Uncategorized';

	$contents .=  '"'.$row->title.'",';
	$contents .=  '"'.$row->cat_title.'",';
	$contents .=  '"'.$row->mstat_time.'",'; 
	$contents .=  '"'.$row->name.'",'; 
	$contents .=  '"'.$row->email.'",'; 
	if ($cfg->continued) {
		$contents .= '"'.$row->UserGroup.'",';
	}
	$contents .=  '"'.$row->mstat_session.'",'; 
	$contents .=  '"'.$row->mstat_ipaddr."\"\n"; 
}

JFile::write($path.$filename,$contents);

 $app = JFactory::getApplication();
 $app->redirect('../cache/'.$filename);