
<div class="view split-view">
	
	<!-- SymbolSets List -->
	<div class="view">
	
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
		<div class="scrollable">
			<div class="list-view" id="role-list">
				<?php foreach ($records as $record) : ?>
					<?php $record = (array)$record;?>
					<div class="list-item" data-id="<?php echo $record['id']; ?>">
						<p>
							<b><?php echo (empty($record['symbolsets_name']) ? $record['id'] : $record['symbolsets_name']); ?></b><br/>
							<span class="small"><?php echo (empty($record['symbolsets_description']) ? lang('symbolsets_edit_text') : $record['symbolsets_description']);  ?></span>
						</p>
					</div>
				<?php endforeach; ?>
			</div>	<!-- /list-view -->
		</div>
	
	<?php else: ?>
	
	<div class="notification attention">
		<p><?php echo lang('symbolsets_no_records'); ?> <?php echo anchor(SITE_AREA .'/content/symbolsets/create', lang('symbolsets_create_new'), array("class" => "ajaxify")) ?></p>
	</div>
	
	<?php endif; ?>
	</div>
	<!-- SymbolSets Editor -->
	<div id="content" class="view">
		<div class="scrollable" id="ajax-content">
				
			<div class="box create rounded">
				<a class="button good ajaxify" href="<?php echo site_url(SITE_AREA .'/content/symbolsets/create')?>"><?php echo lang('symbolsets_create_new_button');?></a>

				<h3><?php echo lang('symbolsets_create_new');?></h3>

				<p><?php echo lang('symbolsets_edit_text'); ?></p>
			</div>
			<br />
				<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
					<h2>SymbolSets</h2>
	<table>
		<thead>
		<th>Name</th>
		<th>SymbolSetFile</th>
		<th>T</th><th><?php echo lang('symbolsets_actions'); ?></th>
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
				<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('symbolsets_true') : lang('symbolsets_false')) : $value; ?></td>

<?php
		}
	}
?>
				<td><?php echo anchor(SITE_AREA .'/content/symbolsets/edit/'. $record['id'], lang('symbolsets_edit'), 'class="ajaxify"'); ?></td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
				<?php endif; ?>
				
		</div>	<!-- /ajax-content -->
	</div>	<!-- /content -->
</div>
