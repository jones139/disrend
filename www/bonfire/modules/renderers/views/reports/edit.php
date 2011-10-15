
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($renderers) ) {
	$renderers = (array)$renderers;
}
$id = isset($renderers['id']) ? "/".$renderers['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('User ID', 'renderers_userId'); ?>
        <input id="renderers_userId" type="text" name="renderers_userId" maxlength="3" value="<?php echo set_value('renderers_userId', isset($renderers['renderers_userId']) ? $renderers['renderers_userId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Description', 'renderers_description'); ?>
        <input id="renderers_description" type="text" name="renderers_description" maxlength="255" value="<?php echo set_value('renderers_description', isset($renderers['renderers_description']) ? $renderers['renderers_description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Renderer Spec', 'renderers_rendererSpec'); ?>
        <input id="renderers_rendererSpec" type="text" name="renderers_rendererSpec"  value="<?php echo set_value('renderers_rendererSpec', isset($renderers['renderers_rendererSpec']) ? $renderers['renderers_rendererSpec'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Renderer Status', 'renderers_rendererStatus'); ?>
        <input id="renderers_rendererStatus" type="text" name="renderers_rendererStatus" maxlength="3" value="<?php echo set_value('renderers_rendererStatus', isset($renderers['renderers_rendererStatus']) ? $renderers['renderers_rendererStatus'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit Renderers" /> or <?php echo anchor(SITE_AREA .'/reports/renderers', lang('renderers_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/reports/renderers/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('renderers_delete_confirm'); ?>')"><?php echo lang('renderers_delete_record'); ?></a>
		
		<h3><?php echo lang('renderers_delete_record'); ?></h3>
		
		<p><?php echo lang('renderers_edit_text'); ?></p>
	</div>
