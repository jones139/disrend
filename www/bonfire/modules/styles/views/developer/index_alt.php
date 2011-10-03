<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . developer .'/'. styles .'/create'); ?>">
		<?php echo lang('styles_create_new_button'); ?>
	</a>

	<h3><?php echo lang('styles_create_new'); ?></h3>

	<p><?php echo lang('styles_edit_text'); ?></p>

</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<h2>Styles</h2>
	<table>
		<thead>
		
			
		<th>StyleFile</th>
		<th>Sample Image</th>
		<th>Thumbnail</th>
		
			<th><?php echo lang('styles_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('styles_true') : lang('styles_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/developer/styles/edit/'. $record[$primary_key_field], lang('styles_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>