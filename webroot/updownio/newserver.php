<?php include("templates/page_header.php");?>
<?php include("lib/auth.php") ?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$status = system('if fping "' . $_POST["ipaddress"] . '" | grep -q "is alive" ;then echo 1; else echo 0; fi');
		add_server($dbconn, $_POST["name"], $_POST["ipaddress"], $_POST["dhcp"], $_POST["type"], $_POST["OS"], $_POST["vmip"], $_POST["wakeonlan"], $_POST["description"], $_POST["comment"], $status);	
		Header ("Location: admin.php");		
	}
?>

<!doctype html>
<html lang="en">
<head>
	<title>New Server</title>
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

<h2>New Server</h2><br>

<form action='#' method='POST'>
	<div class="form-group row">
		<label for="inputName" class="col-sm-2 col-form-label">Server Name</label>
		<div class="col-sm-10">
			<input type="text" id="inputName" placeholder="Name" required autofocus class="form-control" name='name'>
		</div>
	</div>
	
	<div class="form-group row">
		<label for="inputIP" class="col-sm-2 col-form-label">IP Address</label>
		<div class="col-sm-10">
			<input type="text" id="inputIP" placeholder="IP Address" required class="form-control" name='ipaddress'>
		</div>
	</div>
	
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">DHCP</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="dhcp" id="dhcp1" value="1" checked>
          <label class="form-check-label" for="dhcp1">
            True
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="dhcp" id="dhcp2" value="0">
          <label class="form-check-label" for="dhcp2">
            False
          </label>
        </div>
      </div>
    </div>
  </fieldset>		
	
	<div class="form-group row">
		<label for="inputType" class="col-sm-2 col-form-label">Type</label>
		<div class="col-sm-10">
			<input type="text" id="inputType" placeholder="Type" required class="form-control" name='type'>
		</div>
	</div>
	
	<div class="form-group row">
		<label for="inputOS" class="col-sm-2 col-form-label">Operating System</label>
		<div class="col-sm-10">
			<input type="text" id="inputOS" placeholder="Operating System" required class="form-control" name='OS'>
		</div>
	</div>
	
	<div class="form-group row">
		<label for="inputVMIP" class="col-sm-2 col-form-label">Virtual Machine IP</label>
		<div class="col-sm-10">
			<input type="text" id="inputVMIP" placeholder="Virtual Machine IP" class="form-control" name='vmip'>
		</div>
	</div>
	
	<div class="form-group row">
		<label for="inputWAKE" class="col-sm-2 col-form-label">Wake-On-Lan</label>
		<div class="col-sm-10">
			<input type="text" id="inputWAKE" placeholder="Wake-On-Lan" class="form-control" name='wakeonlan'>
		</div>
	</div>
	
	<div class="form-group row">
		<label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
		<div class="col-sm-10">
			<textarea name='description' class="form-control" id="inputDescription" placeholder="Description" rows='5'></textarea>
		</div>
	</div>
	
	<div class="form-group row">
		<label for="inputComment" class="col-sm-2 col-form-label">Comment</label>
		<div class="col-sm-10">
			<textarea name='comment' class="form-control" id="inputComment" placeholder="Comment" rows='5'></textarea>
		</div>
	</div>

	
	
	<input type="submit" value="Submit" name="submit" class="btn btn-primary">
</form>
<br>

	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
</html>
