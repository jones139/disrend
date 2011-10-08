<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . developer .'/'. mapspecs .'/create'); ?>">
		<?php echo lang('mapspecs_create_new_button'); ?>
	</a>

	<h3><?php echo lang('mapspecs_create_new'); ?></h3>

	<p><?php echo lang('mapspecs_edit_text'); ?></p>

</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<h2>MapSpecs</h2>
	<table>
		<thead>
		
			
		<th>Name</th>
		<th>MapSpec</th>
		<th>Status</th>
		<th>ImageThumbnail</th>
		<th>Image</th>
		
			<th><?php echo lang('mapspecs_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('mapspecs_true') : lang('mapspecs_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/developer/mapspecs/edit/'. $record[$primary_key_field], lang('mapspecs_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>