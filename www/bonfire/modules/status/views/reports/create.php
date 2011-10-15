
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($status) ) {
	$status = (array)$status;
}
$id = isset($status['id']) ? "/".$status['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Description', 'status_description'); ?>
        <input id="status_description" type="text" name="status_description" maxlength="255" value="<?php echo set_value('status_description', isset($status['status_description']) ? $status['status_description'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Create Status" /> or <?php echo anchor(SITE_AREA .'/reports/status', lang('status_cancel')); ?>
	</div>
	<?php echo form_close(); ?>
