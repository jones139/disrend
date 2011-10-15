
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
        <?php echo form_label('User ID', 'mapspecs_userId'); ?>
        <input id="mapspecs_userId" type="text" name="mapspecs_userId" maxlength="3" value="<?php echo set_value('mapspecs_userId', isset($mapspecs['mapspecs_userId']) ? $mapspecs['mapspecs_userId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Description', 'mapspecs_description'); ?>
        <input id="mapspecs_description" type="text" name="mapspecs_description" maxlength="255" value="<?php echo set_value('mapspecs_description', isset($mapspecs['mapspecs_description']) ? $mapspecs['mapspecs_description'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Style ID', 'mapspecs_styleId'); ?>
        <input id="mapspecs_styleId" type="text" name="mapspecs_styleId" maxlength="3" value="<?php echo set_value('mapspecs_styleId', isset($mapspecs['mapspecs_styleId']) ? $mapspecs['mapspecs_styleId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Map Spec', 'mapspecs_mapSpec'); ?>
        <input id="mapspecs_mapSpec" type="text" name="mapspecs_mapSpec"  value="<?php echo set_value('mapspecs_mapSpec', isset($mapspecs['mapspecs_mapSpec']) ? $mapspecs['mapspecs_mapSpec'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Create MapSpecs" /> or <?php echo anchor(SITE_AREA .'/settings/mapspecs', lang('mapspecs_cancel')); ?>
	</div>
	<?php echo form_close(); ?>
