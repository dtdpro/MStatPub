<?php defined('_JEXEC') or die('Restricted access'); 
$mstatConfig = JComponentHelper::getParams('com_mstat');
$cfg = $mstatConfig->toObject();
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
				if ($cfg->continued) {
					echo JText::_(' User Group:').JHTML::_('select.genericlist',$this->grouplist,'filter_group','onchange="submitform();"','value','text',$this->filter_group,'filter_group');
				}
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
			<?php 
				if ($cfg->continued) {
					echo '<th>'.JText::_( 'Group' ).'</th>';
				}
			?>
        	<th width="70"><?php echo JText::_( 'Session' ); ?></th>
        	<th width="70"><?php echo JText::_( 'IP Address' ); ?></th>
		</tr>			
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		if ($row->mstat_user == 0) $row->name='Guest';

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo $i + 1 + $this->pagination->limitstart; ?></td>
			<td><?php echo $row->title; ?></td>
			<td><?php echo $row->cat_title; ?></td>
            <td><?php echo $row->mstat_time; ?></td>
			<td><?php echo $row->name; ?></td>
			<?php 
				if ($cfg->continued) {
					echo '<td>'.$row->UserGroup.'</td>';
				}
			?>
			<td><?php echo $row->mstat_session; ?></td>
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
