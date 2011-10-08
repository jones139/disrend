<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . developer .'/'. rendererlist .'/create'); ?>">
		<?php echo lang('rendererlist_create_new_button'); ?>
	</a>

	<h3><?php echo lang('rendererlist_create_new'); ?></h3>

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
		<th>Status</th>
		
			<th><?php echo lang('rendererlist_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('rendererlist_true') : lang('rendererlist_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/developer/rendererlist/edit/'. $record[$primary_key_field], lang('rendererlist_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>