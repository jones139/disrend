<!--
This view is the main site template - to display a page, set $main_content to point to the
view you want to display, and load this template.	
	
-->

<?php $this->load->view('include/header'); ?>

<?php
if(isset($data)) {
	$this -> load -> view($main_content, $data);
} else {
	$this -> load -> view($main_content);
}?>

<?php $this->load->view('include/footer'); ?>