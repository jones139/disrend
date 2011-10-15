<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . settings .'/'. status .'/create'); ?>">
		<?php echo lang('status_create_new_button'); ?>
	</a>

	<h3><?php echo lang('status_create_new'); ?></h3>

	<p><?php echo lang('status_edit_text'); ?></p>

</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<h2>Status</h2>
	<table>
		<thead>
		
			
		<th>Description</th>
		
			<th><?php echo lang('status_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('status_true') : lang('status_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/settings/status/edit/'. $record[$primary_key_field], lang('status_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>