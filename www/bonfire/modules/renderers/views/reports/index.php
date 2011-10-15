
<div class="view split-view">
	
	<!-- Renderers List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['renderers_name']) ? $record['id'] : $record['renderers_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['renderers_description']) ? lang('renderers_edit_text') : $record['renderers_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('renderers_no_records'); ?> <?php echo anchor(SITE_AREA .'/reports/renderers/create', lang('renderers_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- Renderers Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/reports/renderers/create')?>"><?php echo lang('renderers_create_new_button');?></a>

				<h3><?php echo lang('renderers_create_new');?></h3>

				<p><?php echo lang('renderers_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>Renderers</h2>
	<table>
		<thead>
		<th>User ID</th>
		<th>Description</th>
		<th>Renderer Spec</th>
		<th>Renderer Status</th><th><?php echo lang('renderers_actions'); ?></th>
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
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('renderers_true') : lang('renderers_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/reports/renderers/edit/'. $record['id'], lang('renderers_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
