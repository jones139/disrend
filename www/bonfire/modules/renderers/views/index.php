<div class="box create rounded">

	<h3>Renderers</h3>

</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<table>
		<thead>
		
			
		<th>User ID</th>
		<th>Description</th>
		<th>Renderer Spec</th>
		<th>Renderer Status</th>
		
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

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>