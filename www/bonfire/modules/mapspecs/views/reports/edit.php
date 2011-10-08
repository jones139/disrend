
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($mapspecs) ) {
	$mapspecs = (array)$mapspecs;
}
$id = isset($mapspecs['id']) ? "/".$mapspecs['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Name', 'mapspecs_name'); ?>
        <input id="mapspecs_name" type="text" name="mapspecs_name" maxlength="255" value="<?php echo set_value('mapspecs_name', isset($mapspecs['mapspecs_name']) ? $mapspecs['mapspecs_name'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('MapSpec', 'mapspecs_mapSpec'); ?>
        <input id="mapspecs_mapSpec" type="text" name="mapspecs_mapSpec"  value="<?php echo set_value('mapspecs_mapSpec', isset($mapspecs['mapspecs_mapSpec']) ? $mapspecs['mapspecs_mapSpec'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Status', 'mapspecs_status'); ?>
        <input id="mapspecs_status" type="text" name="mapspecs_status" maxlength="3" value="<?php echo set_value('mapspecs_status', isset($mapspecs['mapspecs_status']) ? $mapspecs['mapspecs_status'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('ImageThumbnail', 'mapspecs_imageThumbnail'); ?>
        <input id="mapspecs_imageThumbnail" type="text" name="mapspecs_imageThumbnail"  value="<?php echo set_value('mapspecs_imageThumbnail', isset($mapspecs['mapspecs_imageThumbnail']) ? $mapspecs['mapspecs_imageThumbnail'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Image', 'mapspecs_image'); ?>
        <input id="mapspecs_image" type="text" name="mapspecs_image"  value="<?php echo set_value('mapspecs_image', isset($mapspecs['mapspecs_image']) ? $mapspecs['mapspecs_image'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit MapSpecs" /> or <?php echo anchor(SITE_AREA .'/reports/mapspecs', lang('mapspecs_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/reports/mapspecs/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('mapspecs_delete_confirm'); ?>')"><?php echo lang('mapspecs_delete_record'); ?></a>
		
		<h3><?php echo lang('mapspecs_delete_record'); ?></h3>
		
		<p><?php echo lang('mapspecs_edit_text'); ?></p>
	</div>
