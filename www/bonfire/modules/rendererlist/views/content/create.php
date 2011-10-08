
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($rendererlist) ) {
	$rendererlist = (array)$rendererlist;
}
$id = isset($rendererlist['id']) ? "/".$rendererlist['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Bbox', 'rendererlist_bbox'); ?>
        <input id="rendererlist_bbox" type="text" name="rendererlist_bbox" maxlength="255" value="<?php echo set_value('rendererlist_bbox', isset($rendererlist['rendererlist_bbox']) ? $rendererlist['rendererlist_bbox'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Name', 'rendererlist_name'); ?>
        <input id="rendererlist_name" type="text" name="rendererlist_name" maxlength="255" value="<?php echo set_value('rendererlist_name', isset($rendererlist['rendererlist_name']) ? $rendererlist['rendererlist_name'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('URL', 'rendererlist_url'); ?>
        <input id="rendererlist_url" type="text" name="rendererlist_url" maxlength="255" value="<?php echo set_value('rendererlist_url', isset($rendererlist['rendererlist_url']) ? $rendererlist['rendererlist_url'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Status', 'rendererlist_status'); ?>
        <input id="rendererlist_status" type="text" name="rendererlist_status" maxlength="3" value="<?php echo set_value('rendererlist_status', isset($rendererlist['rendererlist_status']) ? $rendererlist['rendererlist_status'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Create rendererList" /> or <?php echo anchor(SITE_AREA .'/content/rendererlist', lang('rendererlist_cancel')); ?>
	</div>
	<?php echo form_close(); ?>
