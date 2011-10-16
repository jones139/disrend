<div class="box create rounded">

	<h3>Upload a new Symbol Set</h3>

</div>

<div id="formDiv">
<?php echo form_open_multipart('symbolsets/create') ?>

<div>
  <?php echo form_label('Description', 'symbolsets_description'); ?>
  <input id="symbolsets_description" 
         type="text" 
         name="symbolsets_description" 
         maxlength="255" 
         value=""
         placeholder="Enter Symbol Set Description"
  />
</div>

<div>
        <?php echo form_label('SymbolSet', 'symbolsets_symbolSetArch'); ?>
        <input id="userfile" type="file" name="userfile"  />
</div>

<div class="submits">
      <input type="submit" name="submit" value="Upload Symbol Set" />
  </div>

</div>