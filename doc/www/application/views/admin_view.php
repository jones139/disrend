<?php
  $role = $this->session->userdata('role');
  if ($role==2) {
    echo "<h1>Administration Functions</h1>";
    echo anchor("login/list_users","List Users");
  } else {
    echo "<h1>ERROR:  Only an Administrator can access Admin Functions</h1>";
  }


?>