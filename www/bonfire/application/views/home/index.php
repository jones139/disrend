
<h2>Welcome to Maps3.org.uk.</h2>

<p>This is Graham's bit of internet - it is links to a number of projects
I have been working on, in particular to do with
<a href="http://www.openstreetmap.org">OpenStreetMap</a>.</p>

<?php 
if ($this->auth->is_logged_in()) :
    echo "Welcome ".$this->auth->username()."."; 
    echo " ".anchor('/users/logout','Log Out');
else :
    echo "Not Logged In";
    echo anchor('/users/login','Log In');
    echo " / ".anchor('/users/register','Register');
endif
?>
<ol>
<li><?php echo anchor('/login','Log In');?></li>
<li><?php echo anchor('/gpxfiles','GPX Files');?></li>
</ol>
<br/>

<?php  
	// acessing our userdata cookie
	$cookie = unserialize($this->input->cookie($this->config->item('sess_cookie_name')));
	$logged_in = isset ($cookie['logged_in']);
	unset ($cookie);
		
if ($logged_in) : 

?>
        
	<div class="notification attention" style="text-align: center">
		<?php echo anchor(SITE_AREA, 'Administration Functions'); ?>
	</div>

<?php else :?>

	<p style="text-align: center">
		<?php echo anchor('/login', 'Login'); ?>
	</p>

<?php endif;?>