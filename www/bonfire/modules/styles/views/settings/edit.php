
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
        <?php echo form_label('User ID', 'styles_userId'); ?>
        <input id="styles_userId" type="text" name="styles_userId" maxlength="3" value="<?php echo set_value('styles_userId', isset($styles['styles_userId']) ? $styles['styles_userId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Description', 'styles_description'); ?>
        <input id="styles_description" type="text" name="styles_description" maxlength="255" value="<?php echo set_value('styles_description', isset($styles['styles_description']) ? $styles['styles_description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Base Symbol Set ID', 'styles_baseSymbolSetId'); ?>
        <input id="styles_baseSymbolSetId" type="text" name="styles_baseSymbolSetId" maxlength="3" value="<?php echo set_value('styles_baseSymbolSetId', isset($styles['styles_baseSymbolSetId']) ? $styles['styles_baseSymbolSetId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Symbol Set ID', 'styles_symbolSetId'); ?>
        <input id="styles_symbolSetId" type="text" name="styles_symbolSetId" maxlength="3" value="<?php echo set_value('styles_symbolSetId', isset($styles['styles_symbolSetId']) ? $styles['styles_symbolSetId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Style', 'styles_style'); ?>
        <input id="styles_style" type="text" name="styles_style"  value="<?php echo set_value('styles_style', isset($styles['styles_style']) ? $styles['styles_style'] : ''); ?>"  />
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
