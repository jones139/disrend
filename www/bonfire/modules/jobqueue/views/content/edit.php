
<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs    
if( isset($jobqueue) ) {
	$jobqueue = (array)$jobqueue;
}
$id = isset($jobqueue['id']) ? "/".$jobqueue['id'] : '';
?>
<?php echo form_open($this->uri->uri_string(), 'class="constrained ajax-form"'); ?>
<div>
        <?php echo form_label('User ID', 'jobqueue_userId'); ?>
        <input id="jobqueue_userId" type="text" name="jobqueue_userId" maxlength="3" value="<?php echo set_value('jobqueue_userId', isset($jobqueue['jobqueue_userId']) ? $jobqueue['jobqueue_userId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('MapSpec ID', 'jobqueue_mapSpecId'); ?>
        <input id="jobqueue_mapSpecId" type="text" name="jobqueue_mapSpecId" maxlength="3" value="<?php echo set_value('jobqueue_mapSpecId', isset($jobqueue['jobqueue_mapSpecId']) ? $jobqueue['jobqueue_mapSpecId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Status', 'jobqueue_status'); ?>
        <input id="jobqueue_status" type="text" name="jobqueue_status" maxlength="3" value="<?php echo set_value('jobqueue_status', isset($jobqueue['jobqueue_status']) ? $jobqueue['jobqueue_status'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Renderer ID', 'jobqueue_rendererId'); ?>
        <input id="jobqueue_rendererId" type="text" name="jobqueue_rendererId" maxlength="3" value="<?php echo set_value('jobqueue_rendererId', isset($jobqueue['jobqueue_rendererId']) ? $jobqueue['jobqueue_rendererId'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Submit Time', 'jobqueue_submitTime'); ?>
			<script>head.ready(function(){$('#jobqueue_submitTime').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});});</script>
        <input id="jobqueue_submitTime" type="text" name="jobqueue_submitTime"  value="<?php echo set_value('jobqueue_submitTime', isset($jobqueue['jobqueue_submitTime']) ? $jobqueue['jobqueue_submitTime'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Render Start Time', 'jobqueue_renderStartTime'); ?>
			<script>head.ready(function(){$('#jobqueue_renderStartTime').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});});</script>
        <input id="jobqueue_renderStartTime" type="text" name="jobqueue_renderStartTime"  value="<?php echo set_value('jobqueue_renderStartTime', isset($jobqueue['jobqueue_renderStartTime']) ? $jobqueue['jobqueue_renderStartTime'] : ''); ?>"  />
</div>

<div>
        <?php echo form_label('Status Time', 'jobqueue_statusTime'); ?>
			<script>head.ready(function(){$('#jobqueue_statusTime').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});});</script>
        <input id="jobqueue_statusTime" type="text" name="jobqueue_statusTime"  value="<?php echo set_value('jobqueue_statusTime', isset($jobqueue['jobqueue_statusTime']) ? $jobqueue['jobqueue_statusTime'] : ''); ?>"  />
</div>



	<div class="text-right">
		<br/>
		<input type="submit" name="submit" value="Edit JobQueue" /> or <?php echo anchor(SITE_AREA .'/content/jobqueue', lang('jobqueue_cancel')); ?>
	</div>
	<?php echo form_close(); ?>

	<div class="box delete rounded">
		<a class="button" id="delete-me" href="<?php echo site_url(SITE_AREA .'/content/jobqueue/delete/'. $id); ?>" onclick="return confirm('<?php echo lang('jobqueue_delete_confirm'); ?>')"><?php echo lang('jobqueue_delete_record'); ?></a>
		
		<h3><?php echo lang('jobqueue_delete_record'); ?></h3>
		
		<p><?php echo lang('jobqueue_edit_text'); ?></p>
	</div>
