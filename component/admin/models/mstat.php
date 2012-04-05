<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.modellist');

class MStatModelMStat extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array();
		}
		parent::__construct($config);
	}
		
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');
		$mstatConfig = JComponentHelper::getParams('com_mstat');
		$cfg = $mstatConfig->toObject();
		
		// Load the filter state.
		$startdate		= $this->getUserStateFromRequest( $this->context.'.startdate','startdate',date("Y-m-d",strtotime("-1 months") ));
		$enddate		= $this->getUserStateFromRequest( $this->context.'.enddate','enddate',date("Y-m-d") );
		$filter_cat 	= $this->getUserStateFromRequest( $this->context.'.filter_cat','filter_cat', 'filter_cat', 0 );
		
		$this->setState('startdate', $startdate);
		$this->setState('enddate', $enddate);
		$this->setState('filter_cat', $filter_cat);
		
		
		//ContinuEd Link
		if ($cfg->continued) {
			$filter_group = $this->getUserStateFromRequest( $this->context.'.filter.group','filter_group', 0 );
			$this->setState('filter.group', $filter_group);
		}
		
		// Load the parameters.
		$params = JComponentHelper::getParams('com_mstat');
		$this->setState('params', $params);
		
		// List state information.
		parent::populateState('s.mstat_time', 'desc');
	}

	protected function getListQuery()
	{
	
		$mstatConfig = JComponentHelper::getParams('com_mstat');
		$cfg = $mstatConfig->toObject();

		// Create a new query object.
		$db = JFactory::getDBO();
		$q = $db->getQuery(true);
		
		$startdate = $this->getState('startdate');
		$enddate = $this->getState('enddate');
		$filter_cat = $this->getState('filter_cat');
		
		$q->select('s.*');
		$q->from('#__mstat as s');
		
		$q->select('c.title');
		$q->join('LEFT', '#__content as c ON s.mstat_article = c.id');
		
		$q->select('ca.title as cat_title');
		$q->join('LEFT', '#__categories AS ca ON c.catid = ca.id');
		
		$q->select('u.username,u.name,u.email');
		$q->join('LEFT', '#__users AS u ON u.id = s.mstat_user');
		
		$q->where('date(s.mstat_time) BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
		
		
		if ($cfg->except_iplist) {
			$iplist = explode(",",$cfg->except_iplist);
			$q->where('s.mstat_ipaddr NOT IN ("'.implode('","',$iplist).'")');
		}
		
		if ($cfg->except_userlist) {
			$userlist = explode(",",$cfg->except_userlist);
			$q->where('s.mstat_user NOT IN ("'.implode('","',$userlist).'")');
		}
		
		if (is_numeric($filter_cat)) {
			$cat_tbl = JTable::getInstance('Category', 'JTable');
			$cat_tbl->load($filter_cat);
			$rgt = $cat_tbl->rgt;
			$lft = $cat_tbl->lft;
			$baselevel = (int) $cat_tbl->level;
			$q->where('ca.lft >= '.(int) $lft);
			$q->where('ca.rgt <= '.(int) $rgt);
		}
		
		if ($cfg->continued) {
			$q->select("ceug.ug_name AS UserGroup");
			$q->join('LEFT', '#__ce_usergroup as ceg ON s.mstat_user = ceg.userg_user');
			$q->join('LEFT', '#__ce_ugroups as ceug ON ceg.userg_group = ceug.ug_id');
			// Filter by user group.
			if ($ugroup = $this->getState('filter.group')) {
				$q->where('ceg.userg_group = '.(int) $ugroup);
			}
		}
		
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		
		if ($orderCol == 'l.ordering') {
			$orderCol = 'category_name '.$orderDirn.', l.ordering';
		}
		
		$q->order($db->getEscaped($orderCol.' '.$orderDirn));

		return $q;
	}
	
	public function getItemsCSV()
	{
		// Get a storage key.
		$store = $this->getStoreId();
		
		// Try to load the data from internal storage.
		if (isset($this->cache[$store]))
		{
			return $this->cache[$store];
		}
		
		// Load the list items.
		$query = $this->_getListQuery();
		$items = $this->_getList($query);
		
		// Check for a database error.
		if ($this->_db->getErrorNum())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Add the items to the internal cache.
		$this->cache[$store] = $items;
		
		return $this->cache[$store];
	}
	
	public function getUserGroups() {
		$q  = 'SELECT ug.ug_name as text,ug.ug_id as value FROM #__ce_ugroups as ug';
		$q .= ' ORDER BY ug.ug_name';
		$this->_db->setQuery($q);
		$glist = $this->_db->loadObjectList();
		$glist[]->text='-- All --';
		return $glist;
	}

	
}
