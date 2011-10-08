
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($symbolsets) ) {
	$symbolsets = (array)$symbolsets;
}
$id = isset($symbolsets['id']) ? "/".$symbolsets['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Name', 'symbolsets_Name'); ?>
        <input id="symbolsets_Name" type="text" name="symbolsets_Name" maxlength="50" value="<?php echo set_value('symbolsets_Name', isset($symbolsets['symbolsets_Name']) ? $symbolsets['symbolsets_Name'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('SymbolSetFile', 'symbolsets_symbolSetFile'); ?>
	<?php echo form_textarea( array( 'name' => 'symbolsets_symbolSetFile', 'id' => 'symbolsets_symbolSetFile', 'rows' => '5', 'cols' => '80', 'value' => set_value('symbolsets_symbolSetFile', isset($symbolsets['symbolsets_symbolSetFile']) ? $symbolsets['symbolsets_symbolSetFile'] : '') ) )?>
</div>
<div>
        <?php echo form_label('T', 'symbolsets_thumbnail'); ?>
        <input id="symbolsets_thumbnail" type="text" name="symbolsets_thumbnail"  value="<?php echo set_value('symbolsets_thumbnail', isset($symbolsets['symbolsets_thumbnail']) ? $symbolsets['symbolsets_thumbnail'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit SymbolSets" /> or <?php echo anchor(SITE_AREA .'/settings/symbolsets', lang('symbolsets_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/settings/symbolsets/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('symbolsets_delete_confirm'); ?>')"><?php echo lang('symbolsets_delete_record'); ?></a>
		
		<h3><?php echo lang('symbolsets_delete_record'); ?></h3>
		
		<p><?php echo lang('symbolsets_edit_text'); ?></p>
	</div>
