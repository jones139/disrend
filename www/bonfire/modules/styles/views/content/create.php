
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
		<input type="submit" name="submit" value="Create Styles" /> or <?php echo anchor(SITE_AREA .'/content/styles', lang('styles_cancel')); ?>
	</div>
	<?php echo form_close(); ?>
