<html>
<head>
<title>Townguide</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'application/media/css/townguide.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'application/media/js/leaflet.css'; ?>" />
</head>
<body>
   <div id="header">
      <h1>Townguide</h1>
     <div id="menu">
       <?php echo anchor("townguide/newmap","Create New Map").",";?>
       <?php echo anchor("townguide/listqueue","List Queue").",";?>
       <?php echo anchor("mapspecs/list_mapspecs","List MapSpecs");?>
       <?php echo anchor("gpxfiles/list_gpxfiles","GPX Files");?>
   <?php 
      $role = $this->session->userdata('role');
      if ($role==2) {
	echo ",".anchor("townguide/admin","Admin");
      }
   ?>
     </div>
      <div id="sessioninfo">
         <?php 
            if ($this->session->userdata('logged_in')==1) {
	      echo "Welcome, ";
	      echo anchor("login/edit_user/".
			  $this->session->userdata('user_id'),
			  $this->session->userdata('uname'));
	      $role = $this->session->userdata('role');
	      echo " - (".
	      $this->users_model->role_to_text($role);
	      echo  ") (".anchor("login/logout","Log out").")";
	    }
	    else 
	      {
		echo  anchor("login","Log in");
	      }

          ?>
     </div>
     <div style="clear:both"></div>
   </div>
<div id='main_body'>

