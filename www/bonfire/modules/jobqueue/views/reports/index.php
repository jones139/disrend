
<div class="view split-view">
	
	<!-- JobQueue List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['jobqueue_name']) ? $record['id'] : $record['jobqueue_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['jobqueue_description']) ? lang('jobqueue_edit_text') : $record['jobqueue_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('jobqueue_no_records'); ?> <?php echo anchor(SITE_AREA .'/reports/jobqueue/create', lang('jobqueue_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- JobQueue Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/reports/jobqueue/create')?>"><?php echo lang('jobqueue_create_new_button');?></a>

				<h3><?php echo lang('jobqueue_create_new');?></h3>

				<p><?php echo lang('jobqueue_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>JobQueue</h2>
	<table>
		<thead>
		<th>User ID</th>
		<th>MapSpec ID</th>
		<th>Status</th>
		<th>Renderer ID</th>
		<th>Submit Time</th>
		<th>Render Start Time</th>
		<th>Status Time</th><th><?php echo lang('jobqueue_actions'); ?></th>
		</thead>
		<tbody>
<?php
foreach ($records as $record) : ?>
<?php $record = (array)$record;?>
			<tr>
<?php
	foreach($record as $field => $value)
	{
		if($field != "id") {
?>
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('jobqueue_true') : lang('jobqueue_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/reports/jobqueue/edit/'. $record['id'], lang('jobqueue_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
