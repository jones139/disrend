
<div class="view split-view">
	
	<!-- rendererList List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['rendererlist_name']) ? $record['id'] : $record['rendererlist_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['rendererlist_description']) ? lang('rendererlist_edit_text') : $record['rendererlist_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('rendererlist_no_records'); ?> <?php echo anchor(SITE_AREA .'/content/rendererlist/create', lang('rendererlist_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- rendererList Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/content/rendererlist/create')?>"><?php echo lang('rendererlist_create_new_button');?></a>

				<h3><?php echo lang('rendererlist_create_new');?></h3>

				<p><?php echo lang('rendererlist_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>rendererList</h2>
	<table>
		<thead>
		<th>Bbox</th>
		<th>Name</th>
		<th>URL</th>
		<th>Status</th><th><?php echo lang('rendererlist_actions'); ?></th>
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
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('rendererlist_true') : lang('rendererlist_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/content/rendererlist/edit/'. $record['id'], lang('rendererlist_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
