
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
		<input type="submit" name="submit" value="Edit Status" /> or <?php echo anchor(SITE_AREA .'/content/status', lang('status_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/content/status/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('status_delete_confirm'); ?>')"><?php echo lang('status_delete_record'); ?></a>
		
		<h3><?php echo lang('status_delete_record'); ?></h3>
		
		<p><?php echo lang('status_edit_text'); ?></p>
	</div>
