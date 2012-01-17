<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MStatControllerMStatE extends MStatController
{

	function csvme() {
		$filename       = 'MStat_Report' . '-' . date("Y-m-d");
		JResponse::setHeader('Content-Type', 'application/octet-stream');
		JResponse::setHeader('Content-Disposition', 'attachment; filename="'. $filename . '.csv"');
		$model = $this->getModel('mstat');
		$items = $model->getItemsCSV();
		
		echo "\"Article\",\"Category\",\"When\",\"Who\",\"Session\"\n";
		for ($i=0, $n=count( $items ); $i < $n; $i++)
		{
			$row = &$items[$i];
			if ($row->mstat_user == 0) $row->username='Guest';
			if (!$row->sctitle) $row->sctitle = 'Uncategorized';

			echo '"'.$row->title.'",';
			echo '"'.$row->cat_title.'",';
			echo '"'.$row->mstat_time.'",'; 
			echo '"'.$row->username.'",'; 
			echo '"'.$row->mstat_session."\"\n"; 
		}
	}
	
}
?>
