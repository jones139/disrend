
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
        <?php echo form_label('MapSpecJSON', 'mapspecs_mapSpecJSON'); ?>
	<?php echo form_textarea( array( 'name' => 'mapspecs_mapSpecJSON', 'id' => 'mapspecs_mapSpecJSON', 'rows' => '5', 'cols' => '80', 'value' => set_value('mapspecs_mapSpecJSON', isset($mapspecs['mapspecs_mapSpecJSON']) ? $mapspecs['mapspecs_mapSpecJSON'] : '') ) )?>
</div>
<div>
        <?php echo form_label('style', 'mapspecs_styleId'); ?>
        <input id="mapspecs_styleId" type="text" name="mapspecs_styleId" maxlength="3" value="<?php echo set_value('mapspecs_styleId', isset($mapspecs['mapspecs_styleId']) ? $mapspecs['mapspecs_styleId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('SymbolSet', 'mapspecs_symbolSetId'); ?>
        <input id="mapspecs_symbolSetId" type="text" name="mapspecs_symbolSetId" maxlength="3" value="<?php echo set_value('mapspecs_symbolSetId', isset($mapspecs['mapspecs_symbolSetId']) ? $mapspecs['mapspecs_symbolSetId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Status', 'mapspecs_Status'); ?>
        <input id="mapspecs_Status" type="text" name="mapspecs_Status" maxlength="3" value="<?php echo set_value('mapspecs_Status', isset($mapspecs['mapspecs_Status']) ? $mapspecs['mapspecs_Status'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Image', 'mapspecs_Image'); ?>
        <input id="mapspecs_Image" type="text" name="mapspecs_Image"  value="<?php echo set_value('mapspecs_Image', isset($mapspecs['mapspecs_Image']) ? $mapspecs['mapspecs_Image'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Thumbnail', 'mapspecs_thumbnail'); ?>
        <input id="mapspecs_thumbnail" type="text" name="mapspecs_thumbnail"  value="<?php echo set_value('mapspecs_thumbnail', isset($mapspecs['mapspecs_thumbnail']) ? $mapspecs['mapspecs_thumbnail'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit MapSpecs" /> or <?php echo anchor(SITE_AREA .'/developer/mapspecs', lang('mapspecs_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/developer/mapspecs/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('mapspecs_delete_confirm'); ?>')"><?php echo lang('mapspecs_delete_record'); ?></a>
		
		<h3><?php echo lang('mapspecs_delete_record'); ?></h3>
		
		<p><?php echo lang('mapspecs_edit_text'); ?></p>
	</div>
