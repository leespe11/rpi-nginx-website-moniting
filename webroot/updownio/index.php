<?php include("templates/page_header.php");?>
<!doctype html>
<html lang="en">
<head>
	<title>Home</title>
	<?php include("templates/header.php"); ?>
</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

	<h3 class="pb-4 mb-4 font-italic">Servers</h3>
<table class="table table-striped">
  <tr class="thead-dark">	  
	<?php include("templates/table_header.php"); ?>
  </tr>	
  	<?php
		$result = get_servers_list($dbconn);
		while ($row = mysqli_fetch_array($result)) {
	?>

<tr>
  <td style="text-align:center"><svg class="bi bi-circle-fill" fill="<?php if($row['status'] == 1){ echo "green"; }else{ echo "red";} ?>" viewBox="0 0 16 16" width="1.5em" height="1.5em"><circle cx="8" cy="8" r="8"></circle></svg></td>
  <td><?php echo $row['name'] ?></td>
  <td><?php echo $row['ipaddress'] ?></td>
  <td><?php if($row['DHCP']){echo "False";}else{echo "True";} ?></td>
  <td><?php echo $row['type'] ?></td>
  <td><?php echo $row['OS'] ?></td>
  <td><?php echo $row['vmip'] ?></td>
  <td><?php echo $row['description'] ?></td>	
  <td><?php echo $row['comment'] ?></td>	
</tr>

	<?php } //close while loop ?>
	</table>

	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>

</html>
