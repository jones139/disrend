<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . settings .'/'. jobqueue .'/create'); ?>">
		<?php echo lang('jobqueue_create_new_button'); ?>
	</a>

	<h3><?php echo lang('jobqueue_create_new'); ?></h3>

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
		<th>Status Time</th>
		
			<th><?php echo lang('jobqueue_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('jobqueue_true') : lang('jobqueue_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/settings/jobqueue/edit/'. $record[$primary_key_field], lang('jobqueue_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>