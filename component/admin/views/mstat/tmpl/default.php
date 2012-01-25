<?php defined('_JEXEC') or die('Restricted access'); 
$monthsl[1] = JHTML::_('select.option',  '','--None--');
$monthsl[2] = JHTML::_('select.option',  '1','Jan');
$monthsl[3] = JHTML::_('select.option',  '2','Feb');
$monthsl[4] = JHTML::_('select.option',  '3','Mar');
$monthsl[5] = JHTML::_('select.option',  '4','Apr');
$monthsl[6] = JHTML::_('select.option',  '5','May');
$monthsl[7] = JHTML::_('select.option',  '6','Jun');
$monthsl[8] = JHTML::_('select.option',  '7','Jul');
$monthsl[9] = JHTML::_('select.option',  '8','Aug');
$monthsl[10] = JHTML::_('select.option',  '9','Sep');
$monthsl[11] = JHTML::_('select.option',  '10','Oct');
$monthsl[12] = JHTML::_('select.option',  '11','Nov');
$monthsl[13] = JHTML::_('select.option',  '12','Dec');

$yearsl[] = JHTML::_('select.option',  '','--None--');
for ($y=2008; $y <= date("Y"); $y++) {$yearsl[] = JHTML::_('select.option',  $y,$y);}
?>
<form action="" method="post" name="adminForm">
<div id="editcell">
	<table class="adminlist">
    	<thead><tr>
        	<th align="left" width="50%"><?php

            ?></th>
            <th align="right" width="50%"><?php
				echo 'Start: '.JHTML::_('calendar',$this->startdate,'startdate','startdate','%Y-%m-%d','onchange="this.form.submit()"');
				echo ' End: '.JHTML::_('calendar',$this->enddate,'enddate','enddate','%Y-%m-%d','onchange="this.form.submit()"');
            ?>
	            <select name="filter_cat" class="inputbox" onchange="this.form.submit()">
					<option value="">- Select Category -</option>
					<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_content'), 'value', 'text', $this->filter_cat);?>
				</select>
			</th>
        </tr></thead>
    </table> 
	<table class="adminlist">
	<thead>
		<tr>
			<th width="60"><?php echo JText::_( 'NUM' ); ?></th>
			<th><?php echo JText::_( 'Article' ); ?></th>
			<th><?php echo JText::_( 'Category' ); ?></th>
			<th><?php echo JText::_( 'When' ); ?></th>
			<th><?php echo JText::_( 'Who' ); ?></th>
        	<th width="70"><?php echo JText::_( 'Session' ); ?></th>
        	<th width="70"><?php echo JText::_( 'IP Address' ); ?></th>
		</tr>			
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		if ($row->mstat_user == 0) $row->username='Guest';
		
		$userlink = $row->username;
		$sessionlink = $row->mstat_session;
		$artlink = $row->title;
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo $i + 1 + $this->pagination->limitstart; ?></td>
			<td><?php echo $artlink; ?></td>
			<td><?php echo $row->cat_title; ?></td>
            <td><?php echo $row->mstat_time; ?></td>
			<td><?php 
				if ($row->mstat_user != 0) echo $userlink;
				else echo $row->username; 
			?></td>
			<td><?php echo $sessionlink; ?></td>
			<td><?php echo $row->mstat_ipaddr; ?></td>

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
         <tfoot>
		<td colspan="7">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="option" value="com_mstat" /> 
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" /> 
<input type="hidden" name="controller" value="mstat" />
</form>
