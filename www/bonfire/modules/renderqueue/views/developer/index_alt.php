<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . developer .'/'. renderqueue .'/create'); ?>">
		<?php echo lang('renderqueue_create_new_button'); ?>
	</a>

	<h3><?php echo lang('renderqueue_create_new'); ?></h3>

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
		<th>spare</th>
		
			<th><?php echo lang('renderqueue_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('renderqueue_true') : lang('renderqueue_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/developer/renderqueue/edit/'. $record[$primary_key_field], lang('renderqueue_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>