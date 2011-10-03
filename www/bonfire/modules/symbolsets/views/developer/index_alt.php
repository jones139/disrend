<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . developer .'/'. symbolsets .'/create'); ?>">
		<?php echo lang('symbolsets_create_new_button'); ?>
	</a>

	<h3><?php echo lang('symbolsets_create_new'); ?></h3>

	<p><?php echo lang('symbolsets_edit_text'); ?></p>

</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<h2>SymbolSets</h2>
	<table>
		<thead>
		
			
		<th>Name</th>
		<th>SymbolSetFile</th>
		<th>T</th>
		
			<th><?php echo lang('symbolsets_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('symbolsets_true') : lang('symbolsets_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/developer/symbolsets/edit/'. $record[$primary_key_field], lang('symbolsets_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>