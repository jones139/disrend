<?php
	  // Auth setup
	  $this->load->model('users/User_model', 'user_model');
	  $this->load->library('users/auth');
	  $this->load->model('permissions/permission_model');
	  $this->load->model('roles/role_permission_model');
	  $this->load->model('roles/role_model');



	// Setup our default assets to load.
	Assets::add_js( array(
		base_url() .'assets/js/jquery-1.5.min.js',
	));
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	
	<title><?php echo config_item('site.title'); ?></title>

	<?php echo Assets::css(); ?>
	
	<?php echo Assets::external_js('head.min.js'); ?>
</head>
<body>

	<div class="page">
	
		<!-- Header -->
		<div class="head text-right">
			<h1>Maps3 Theme</h1>
	  <?php 
	  if ($this->auth->is_logged_in()) :
	    $roleId = $this->auth->role_id();
            $roleStr = $this->auth->role_name_by_id($roleId);
	    echo "Welcome ".$this->auth->username()." (".$roleStr.")."; 
            echo " ".anchor('/users/logout','Log Out');
          else :
            echo "Not Logged In: ";
            echo anchor('/users/login','Log In');
            echo " / ".anchor('/users/register','Register');
            endif
          ?>

		</div>
		
		<div class="main">
			<?php echo Template::message(); ?>
			<?php echo isset($content) ? $content : Template::yield(); ?>

		</div>	<!-- /main -->
	</div>	<!-- /page -->
	
	<div class="foot">
		<?php if (ENVIRONMENT == 'development') :?>
			<p style="float: right; margin-right: 80px;">Page rendered in {elapsed_time} seconds, using {memory_usage}.</p>
		<?php endif; ?>
		
		<p>Powered by <a href="http://cibonfire.com" target="_blank">Bonfire <?php echo BONFIRE_VERSION ?></a></p>
	</div>
	
	<div id="debug"></div>
	
	<script>
		head.js(<?php echo Assets::external_js(null, true) ?>);
	</script>
	<?php echo Assets::inline_js(); ?>
</body>
</html>