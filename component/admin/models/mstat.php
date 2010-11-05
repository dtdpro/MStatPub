<?php
/**
 * Hellos Model for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class MStatModelMStat extends JModel
{

	var $_data;
	var $_total = null;
	var $_pagination = null;

	function __construct()
	{
		parent::__construct();

		global $mainframe, $context;
		
		$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

	}

	function _buildQuery()
	{
		$user = JRequest::getVar('filter_user');
		$session = JRequest::getVar('filter_session');
		$month = JRequest::getVar('filter_month');
		$year = JRequest::getVar('filter_year');
		$cat = JRequest::getVar('filter_cat');
		$article = JRequest::getVar('filter_article');
		$tand = 0;
		
		$q  = 'SELECT s.*,c.title,u.username,CONCAT(sc.title," - ",ca.title) as sctitle FROM #__mstat as s ';
		$q .= 'LEFT JOIN #__content as c ON s.mstat_article = c.id ';
		$q .= 'LEFT JOIN #__users as u ON s.mstat_user = u.id ';
		$q .= 'LEFT JOIN #__categories as ca ON c.catid = ca.id ';
		$q .= 'LEFT JOIN #__sections as sc ON ca.section = sc.id ';
		if ($user || $session || $month || $year || $cat || $article) $q .= ' WHERE ';
		if ($user) { $q .= 's.mstat_user = "'.$user.'"'; $tand = 1; }
		if ($session) { if ($tand) { $q .= ' && '; $tand = 0; } $q .= ' s.mstat_session = "'.$session.'"'; $tand = 1; }
		if ($month) { if ($tand) { $q .= ' && '; $tand = 0; } $q .= ' MONTH(s.mstat_time) = "'.$month.'"'; $tand = 1; }
		if ($year) { if ($tand) { $q .= ' && '; $tand = 0; } $q .= ' YEAR(s.mstat_time) = "'.$year.'"'; $tand = 1; }
		if ($cat) { if ($tand) { $q .= ' && '; $tand = 0; } $q .= ' s.mstat_cat = "'.$cat.'"'; $tand = 1; }
		if ($article) { if ($tand) { $q .= ' && '; $tand = 0; } $q .= ' s.mstat_article = "'.$article.'"'; $tand = 1; }
		$q .= ' ORDER BY s.mstat_time DESC';

		return $q;
	}

	function getData()
	{
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_data;
	}
	function getDataCSV()
	{
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query);
		}

		return $this->_data;
	}


	function getTotal()
	{
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	function getCatList() {
		$db =& JFactory::getDBO();
		$query  = ' SELECT *,c.id as catid,CONCAT(s.title," - ",c.title) as sctitle FROM #__categories as c ';
		$query .= ' RIGHT JOIN #__sections as s ON c.section = s.id ';
		$query .= 'ORDER BY s.title, c.title ASC';
		$db->setQuery( $query );
		$catlist = $db->loadObjectList();
		$cats[]=JHTML::_('select.option','','--All--');
		foreach ($catlist as $cl) {
			$cats[]=JHTML::_('select.option',$cl->catid,$cl->sctitle);
		}
		return $cats;
	
	}

}
