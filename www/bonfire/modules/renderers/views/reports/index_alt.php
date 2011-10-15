<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . reports .'/'. renderers .'/create'); ?>">
		<?php echo lang('renderers_create_new_button'); ?>
	</a>

	<h3><?php echo lang('renderers_create_new'); ?></h3>

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
		<th>Renderer Status</th>
		
			<th><?php echo lang('renderers_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('renderers_true') : lang('renderers_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/reports/renderers/edit/'. $record[$primary_key_field], lang('renderers_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>