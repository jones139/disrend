<h1>List Queue</h1>
<table border="1">
   <tr>
   <th>Job No</th> 
   <th>Status</th>
   <th>Date Submitted</th>
   <th>Options</th>
   <?php $authenticated=False;?>
   </tr>
   <?php foreach ($query->result() as $row):?>

   <tr>
   <?php 
   echo "<td>".$row->job_id."</td>";
   echo "<td>";
   switch ($row->status) {
   case 0:
    echo "Queued";
    break;
    case 1:
      echo "Running";
      break;
    case 2:
      echo "Complete";
      break;
    case 3:
      echo "Failed";
      break;
    default:
      echo "Unknown Status (".$row->status.")";
  }
  echo "</td>";
echo "<td>".$row->submit_time."</td>";
  echo "<td>".anchor("townguide/deletemap/".$row->job_id,"Delete");
  echo ", ".anchor("townguide/retry_job/".$row->job_id,"Re-Try")."</td>";
?>
</tr>
<?php endforeach;?>
</table>