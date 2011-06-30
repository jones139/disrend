<h1>GPX Upload Successful!</h1>
<a href="gpxfiles/list_gpxfiles">List GPX Files</a>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>

<?php echo $gpx; ?>
</ul>

