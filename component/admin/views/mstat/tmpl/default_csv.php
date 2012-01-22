<?php
defined('_JEXEC') or die('Restricted access'); 

jimport( 'joomla.filesystem.file' );

$path = JPATH_SITE.'/cache/';
$filename  =  'MStat_Report' . '-' . date("Y-m-d").'.csv';
$model = $this->getModel('mstat');
$items = $model->getItemsCSV();
$contents = '';	
$contents .= "\"Article\",\"Category\",\"When\",\"Who\",\"Session\",\"IP Address\"\n";
for ($i=0, $n=count( $this->items ); $i < $n; $i++)
{
	$row = &$this->items[$i];
	if ($row->mstat_user == 0) $row->username='Guest';
	if (!$row->sctitle) $row->sctitle = 'Uncategorized';

	$contents .=  '"'.$row->title.'",';
	$contents .=  '"'.$row->cat_title.'",';
	$contents .=  '"'.$row->mstat_time.'",'; 
	$contents .=  '"'.$row->username.'",'; 
	$contents .=  '"'.$row->mstat_session.'",'; 
	$contents .=  '"'.$row->mstat_ipaddr."\"\n"; 
}

JFile::write($path.$filename,$contents);

 $app = JFactory::getApplication();
 $app->redirect('../cache/'.$filename);