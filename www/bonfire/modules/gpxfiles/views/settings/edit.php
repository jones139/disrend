
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($gpxfiles) ) {
	$gpxfiles = (array)$gpxfiles;
}
$id = isset($gpxfiles['id']) ? "/".$gpxfiles['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('User ID', 'gpxfiles_userId'); ?>
        <input id="gpxfiles_userId" type="text" name="gpxfiles_userId" maxlength="4" value="<?php echo set_value('gpxfiles_userId', isset($gpxfiles['gpxfiles_userId']) ? $gpxfiles['gpxfiles_userId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Description', 'gpxfiles_description'); ?>
        <input id="gpxfiles_description" type="text" name="gpxfiles_description" maxlength="512" value="<?php echo set_value('gpxfiles_description', isset($gpxfiles['gpxfiles_description']) ? $gpxfiles['gpxfiles_description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('GPXFile', 'gpxfiles_gpxfile'); ?>
        <input id="gpxfiles_gpxfile" type="text" name="gpxfiles_gpxfile"  value="<?php echo set_value('gpxfiles_gpxfile', isset($gpxfiles['gpxfiles_gpxfile']) ? $gpxfiles['gpxfiles_gpxfile'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit gpxFiles" /> or <?php echo anchor(SITE_AREA .'/settings/gpxfiles', lang('gpxfiles_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/settings/gpxfiles/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('gpxfiles_delete_confirm'); ?>')"><?php echo lang('gpxfiles_delete_record'); ?></a>
		
		<h3><?php echo lang('gpxfiles_delete_record'); ?></h3>
		
		<p><?php echo lang('gpxfiles_edit_text'); ?></p>
	</div>
