
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($renderqueue) ) {
	$renderqueue = (array)$renderqueue;
}
$id = isset($renderqueue['id']) ? "/".$renderqueue['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('Status', 'renderqueue_status'); ?>
        <input id="renderqueue_status" type="text" name="renderqueue_status" maxlength="4" value="<?php echo set_value('renderqueue_status', isset($renderqueue['renderqueue_status']) ? $renderqueue['renderqueue_status'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Renderer', 'renderqueue_rendererId'); ?>
        <input id="renderqueue_rendererId" type="text" name="renderqueue_rendererId" maxlength="4" value="<?php echo set_value('renderqueue_rendererId', isset($renderqueue['renderqueue_rendererId']) ? $renderqueue['renderqueue_rendererId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Status Date', 'renderqueue_statusDate'); ?>
			<script>head.ready(function(){$('#renderqueue_statusDate').datepicker({ dateFormat: 'yy-mm-dd'});});</script>
        <input id="renderqueue_statusDate" type="text" name="renderqueue_statusDate"  value="<?php echo set_value('renderqueue_statusDate', isset($renderqueue['renderqueue_statusDate']) ? $renderqueue['renderqueue_statusDate'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('MapSpec', 'renderqueue_mapSpec'); ?>
        <input id="renderqueue_mapSpec" type="text" name="renderqueue_mapSpec" maxlength="4" value="<?php echo set_value('renderqueue_mapSpec', isset($renderqueue['renderqueue_mapSpec']) ? $renderqueue['renderqueue_mapSpec'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Create renderQueue" /> or <?php echo anchor(SITE_AREA .'/reports/renderqueue', lang('renderqueue_cancel')); ?>
	</div>
	<?php echo form_close(); ?>
