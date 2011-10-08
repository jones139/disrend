
<div class="view split-view">
	
	<!-- Styles List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['styles_name']) ? $record['id'] : $record['styles_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['styles_description']) ? lang('styles_edit_text') : $record['styles_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('styles_no_records'); ?> <?php echo anchor(SITE_AREA .'/settings/styles/create', lang('styles_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- Styles Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/settings/styles/create')?>"><?php echo lang('styles_create_new_button');?></a>

				<h3><?php echo lang('styles_create_new');?></h3>

				<p><?php echo lang('styles_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>Styles</h2>
	<table>
		<thead>
		<th>StyleFile</th>
		<th>Sample Image</th>
		<th>Thumbnail</th><th><?php echo lang('styles_actions'); ?></th>
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
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('styles_true') : lang('styles_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/settings/styles/edit/'. $record['id'], lang('styles_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
