<?php
/**
 * Hello Controller for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * Hello Hello Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class MStatControllerMStatE extends MStatController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

	}

	function csvme() {
		$filename       = 'MStat_Report' . '-' . date("Y-m-d");
		JResponse::setHeader('Content-Type', 'application/octet-stream');
		JResponse::setHeader('Content-Disposition', 'attachment; filename="'. $filename . '.csv"');
		$model = $this->getModel('mstat');
		$items = $model->getDataCSV();
		
		echo "\"Article\",\"Category\",\"When\",\"Who\",\"Session\"\n";
		for ($i=0, $n=count( $items ); $i < $n; $i++)
		{
			$row = &$items[$i];
			if ($row->mstat_user == 0) $row->username='Guest';
			if (!$row->sctitle) $row->sctitle = 'Uncategorized';

			echo '"'.$row->title.'",';
			echo '"'.$row->sctitle.'",';
			echo '"'.$row->mstat_time.'",'; 
			echo '"'.$row->username.'",'; 
			echo '"'.$row->mstat_session."\"\n"; 
		}
	}
	
}
?>
