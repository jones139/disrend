
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
        <?php echo form_label('Status', 'renderqueue_statusId'); ?>
        <input id="renderqueue_statusId" type="text" name="renderqueue_statusId" maxlength="4" value="<?php echo set_value('renderqueue_statusId', isset($renderqueue['renderqueue_statusId']) ? $renderqueue['renderqueue_statusId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('StatusDate', 'renderqueue_statusDate'); ?>
			<script>head.ready(function(){$('#renderqueue_statusDate').datepicker({ dateFormat: 'yy-mm-dd'});});</script>
        <input id="renderqueue_statusDate" type="text" name="renderqueue_statusDate"  value="<?php echo set_value('renderqueue_statusDate', isset($renderqueue['renderqueue_statusDate']) ? $renderqueue['renderqueue_statusDate'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Renderer', 'renderqueue_rendererId'); ?>
        <input id="renderqueue_rendererId" type="text" name="renderqueue_rendererId" maxlength="4" value="<?php echo set_value('renderqueue_rendererId', isset($renderqueue['renderqueue_rendererId']) ? $renderqueue['renderqueue_rendererId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('MapSpec', 'renderqueue_mapSpec'); ?>
        <input id="renderqueue_mapSpec" type="text" name="renderqueue_mapSpec" maxlength="4" value="<?php echo set_value('renderqueue_mapSpec', isset($renderqueue['renderqueue_mapSpec']) ? $renderqueue['renderqueue_mapSpec'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('LogFile', 'renderqueue_logFile'); ?>
	<?php echo form_textarea( array( 'name' => 'renderqueue_logFile', 'id' => 'renderqueue_logFile', 'rows' => '5', 'cols' => '80', 'value' => set_value('renderqueue_logFile', isset($renderqueue['renderqueue_logFile']) ? $renderqueue['renderqueue_logFile'] : '') ) )?>
</div>
<div>
        <?php echo form_label('spare', 'renderqueue_spare'); ?>
        <input id="renderqueue_spare" type="text" name="renderqueue_spare" maxlength="4" value="<?php echo set_value('renderqueue_spare', isset($renderqueue['renderqueue_spare']) ? $renderqueue['renderqueue_spare'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Create renderQueue" /> or <?php echo anchor(SITE_AREA .'/settings/renderqueue', lang('renderqueue_cancel')); ?>
	</div>
	<?php echo form_close(); ?>
