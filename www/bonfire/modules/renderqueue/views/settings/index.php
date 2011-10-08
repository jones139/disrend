
<div class="view split-view">
	
	<!-- renderQueue List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['renderqueue_name']) ? $record['id'] : $record['renderqueue_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['renderqueue_description']) ? lang('renderqueue_edit_text') : $record['renderqueue_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('renderqueue_no_records'); ?> <?php echo anchor(SITE_AREA .'/settings/renderqueue/create', lang('renderqueue_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- renderQueue Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/settings/renderqueue/create')?>"><?php echo lang('renderqueue_create_new_button');?></a>

				<h3><?php echo lang('renderqueue_create_new');?></h3>

				<p><?php echo lang('renderqueue_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>renderQueue</h2>
	<table>
		<thead>
		<th>Status</th>
		<th>StatusDate</th>
		<th>Renderer</th>
		<th>MapSpec</th>
		<th>LogFile</th>
		<th>spare</th><th><?php echo lang('renderqueue_actions'); ?></th>
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
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('renderqueue_true') : lang('renderqueue_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/settings/renderqueue/edit/'. $record['id'], lang('renderqueue_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
