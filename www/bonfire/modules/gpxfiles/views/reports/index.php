
<div class="view split-view">
	
	<!-- gpxFiles List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['gpxfiles_name']) ? $record['id'] : $record['gpxfiles_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['gpxfiles_description']) ? lang('gpxfiles_edit_text') : $record['gpxfiles_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('gpxfiles_no_records'); ?> <?php echo anchor(SITE_AREA .'/reports/gpxfiles/create', lang('gpxfiles_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- gpxFiles Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/reports/gpxfiles/create')?>"><?php echo lang('gpxfiles_create_new_button');?></a>

				<h3><?php echo lang('gpxfiles_create_new');?></h3>

				<p><?php echo lang('gpxfiles_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>gpxFiles</h2>
	<table>
		<thead>
		<th>User ID</th>
		<th>Description</th>
		<th>GPXFile</th><th><?php echo lang('gpxfiles_actions'); ?></th>
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
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('gpxfiles_true') : lang('gpxfiles_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/reports/gpxfiles/edit/'. $record['id'], lang('gpxfiles_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
