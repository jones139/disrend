
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
        <?php echo form_label('User ID', 'symbolsets_userId'); ?>
        <input id="symbolsets_userId" type="text" name="symbolsets_userId" maxlength="3" value="<?php echo set_value('symbolsets_userId', isset($symbolsets['symbolsets_userId']) ? $symbolsets['symbolsets_userId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Description', 'symbolsets_description'); ?>
        <input id="symbolsets_description" type="text" name="symbolsets_description" maxlength="255" value="<?php echo set_value('symbolsets_description', isset($symbolsets['symbolsets_description']) ? $symbolsets['symbolsets_description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('SymbolSet', 'symbolsets_symbolSetArch'); ?>
        <input id="symbolsets_symbolSetArch" type="text" name="symbolsets_symbolSetArch"  value="<?php echo set_value('symbolsets_symbolSetArch', isset($symbolsets['symbolsets_symbolSetArch']) ? $symbolsets['symbolsets_symbolSetArch'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit SymbolSets" /> or <?php echo anchor(SITE_AREA .'/developer/symbolsets', lang('symbolsets_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/developer/symbolsets/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('symbolsets_delete_confirm'); ?>')"><?php echo lang('symbolsets_delete_record'); ?></a>
		
		<h3><?php echo lang('symbolsets_delete_record'); ?></h3>
		
		<p><?php echo lang('symbolsets_edit_text'); ?></p>
	</div>
