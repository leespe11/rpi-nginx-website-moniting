<?php include("templates/page_header.php");?>
<?php include("lib/auth.php") ?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST["subnet"]) && $_POST["subnet"] != NULL){
			add_subnet($dbconn, $_POST["subnet"]);
		}
	}
?>

<!doctype html>
<html lang="en">
<head>
	<title>New Subnet</title>
	<?php include("templates/header.php"); ?>
	<style>
		@media (min-width: 1900px) {
		  .container, .container-sm, .container-md, .container-lg, .container-xl {
			max-width: 1200px;
		  }
		}
	</style>
</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

<h4>Current Subnets</h4><br>
	<table class="table table-striped" style="width:300px;">
		<tr class="thead-dark"><th>Subnet</th><th style="text-align:center">Remove</th></tr>
	<?php 
	$result = get_subnet_list($dbconn);
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr><td>192.168.<span style='color:rgb(24, 25, 253)'>" . $row['value']. "</span>.0/24</td>";
		echo "<td style=\"text-align:center\"><a href=\"\" onclick=\"remove(event, this)\"><i class=\"fa fa-times fa-2x\" aria-hidden=\"true\"></i></a></td></tr>";
	}
	?>
	</table>

<form action="" method='POST'>
	<div class="form-group row">
		<label for="inputName" class="col-sm-2 col-form-label">Subnet</label>
		<div class="col-sm-10">
			<input type="text" id="inputName" placeholder="110" required autofocus class="form-control" name='subnet' style="width:300px;">
		</div>
	</div>
	
	<input type="submit" value="Submit" name="submit" class="btn btn-primary">
</form>
<br>

	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
	
<script type="application/javascript">

$("form").submit(function( event ) {
	event.preventDefault();
	var subnet = $("form input").val();
	if (subnet.indexOf(".") > -1){
		var array = subnet.split(".");
		$("form input").val(array[2]);
		$(this).unbind('submit').submit();
	}else if(!Number.isInteger(parseInt(subnet)) || Math.floor(parseInt(subnet)/255) > 0){
		$("body").append("<div id=\"alert\">Invalid Subnet (e.g. 110, 192.168.110.0, 192.168.110.0/24)<br><br><br><button id=\"alertbtn\" onclick=\"$('#alert').remove();\">[ close ]</button></div>");	
	}else{
		 $(this).unbind('submit').submit();
	}
});
	
function remove(event, me){
	event.preventDefault();
	$.post( "deletesubnet.php", {value: $(me).parent().parent().children().children().html() }).done(function( data ) {
			if(data == "success"){
				$("body").append("<div id=\"alert\">Deletion was Successful<br><br><br><button id=\"alertbtn\" onclick=\"$('#alert').remove();\">[ close ]</button></div>");
				$(me).parent().parent().remove();
			}else{
				$("body").append("<div id=\"alert\">"+data+"<br><br><br><button id=\"alertbtn\" onclick=\"$('#alert').remove();\">[ close ]</button></div>");
			}
	});
}
</script>
</html>

