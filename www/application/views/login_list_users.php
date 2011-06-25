<h1>List Users</h1>
<table border="1">
   <tr>
   <th>User No</th> 
   <th>User ID</th>
   <th>Password</th>
   <th>Role</th>
   <th>Email</th>
   </tr>
   <?php foreach ($query->result() as $row):?>

   <tr>
   <?php 
   echo "<td>".
   anchor("login/edit_user/".$row->user_id,$row->user_id)."</td>";
   echo "<td>".$row->uname."</td>";
   echo "<td>".$row->passwd."</td>";
   echo "<td>".$this->users_model->role_to_text($row->role).
   "</td>";
   echo "<td>".$row->email."</td>";

//  echo "<td>".anchor("townguide/deletemap/".$row->job_id,"Delete");
//  echo ", ".anchor("townguide/retry_job/".$row->job_id,"Re-Try")."</td>";
?>
</tr>
<?php endforeach;?>
</table>