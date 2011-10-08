
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($styles) ) {
	$styles = (array)$styles;
}
$id = isset($styles['id']) ? "/".$styles['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('StyleFile', 'styles_styleFile'); ?>
	<?php echo form_textarea( array( 'name' => 'styles_styleFile', 'id' => 'styles_styleFile', 'rows' => '5', 'cols' => '80', 'value' => set_value('styles_styleFile', isset($styles['styles_styleFile']) ? $styles['styles_styleFile'] : '') ) )?>
</div>
<div>
        <?php echo form_label('Sample Image', 'styles_sampleImage'); ?>
	<?php echo form_textarea( array( 'name' => 'styles_sampleImage', 'id' => 'styles_sampleImage', 'rows' => '5', 'cols' => '80', 'value' => set_value('styles_sampleImage', isset($styles['styles_sampleImage']) ? $styles['styles_sampleImage'] : '') ) )?>
</div>
<div>
        <?php echo form_label('Thumbnail', 'styles_thumbnail'); ?>
	<?php echo form_textarea( array( 'name' => 'styles_thumbnail', 'id' => 'styles_thumbnail', 'rows' => '5', 'cols' => '80', 'value' => set_value('styles_thumbnail', isset($styles['styles_thumbnail']) ? $styles['styles_thumbnail'] : '') ) )?>
</div>


	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit Styles" /> or <?php echo anchor(SITE_AREA .'/settings/styles', lang('styles_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/settings/styles/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('styles_delete_confirm'); ?>')"><?php echo lang('styles_delete_record'); ?></a>
		
		<h3><?php echo lang('styles_delete_record'); ?></h3>
		
		<p><?php echo lang('styles_edit_text'); ?></p>
	</div>