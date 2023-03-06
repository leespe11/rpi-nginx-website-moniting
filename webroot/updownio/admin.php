<?php include("templates/page_header.php");?>
<?php include("lib/auth.php") ?>
<!doctype html>
<html lang="en">
<head>
	<title>Admin</title>
	<?php include("templates/header.php"); ?>
</head>
<body>
	<?php include("templates/nav.php"); ?>
	<?php include("templates/contentstart.php"); ?>

<h2>Server Management</h2>

<p>
	<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="window.location='newserver.php';">
		Add Server <span class="fa fa-plus" aria-hidden="true"></span>
	</button>
	<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="window.location='subnets.php';">
		Config Subnets <span class="fa fa-plus" aria-hidden="true"></span>
	</button>	
</p>


<table class="table table-striped">
  <tr class="thead-dark">
	<?php include("templates/table_header.php"); ?>
	<th style="width:55px;">Wake</th>
    <th style="width:55px;">Modify</th>
	<th style="width:55px;">Save</th>
	<th style="width:55px;">Delete</th>
  </tr>

<?php
// get articles by user or, if role is admin, all articles
		$result = get_servers_list($dbconn);
		while ($row = mysqli_fetch_array($result)) {
			// Print articles owned by user, or all articles if the user is admin
			if($_SESSION["role"] == "admin"){
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
  <td><a href="" data-mac="<?php echo $row['wakeonlan'];?>" onclick="wake(event, this, '<?php echo $row['wakeonlan'];?>', '<?php echo $row['ipaddress'];?>')" <?php if ($row['wakeonlan'] == "" || $row['wakeonlan'] == "NULL") {echo'style="color:black;pointer-events: none;pointer:none;"';}?>><i class="fa fa-clock-o fa-2x" aria-hidden="true" ></i></a></td>
  <td><a href="" onclick="edit(event, this)"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a></td>
  <td><a href="" onclick="save(event, this, <?php echo $row['ID'];?>)"><i class="fa fa-check fa-2x" aria-hidden="true"></i></a></td>
  <td><a href="" onclick="remove(event, this, <?php echo $row['ID']; ?>)"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></td>
</tr>
	<?php	} //close if loop 
		} //close while loop ?>
</table>
	<?php include("templates/contentstop.php"); ?>
	<?php include("templates/footer.php"); ?>
</body>
<script type="application/javascript">
	var modifyState = "deselected";
	var lastIndex;
	var arrayUnmodify = [];
	
	
	function edit(event, me){
		event.preventDefault();
		if(modifyState == "selected" && me != lastIndex){
			modifyState = "deselected";
			edit(event, lastIndex);
		}
		counter=0;
		$(me).parent().parent().children().each(function(){
			if(this.innerHTML.indexOf("<a href") == -1 && this.innerHTML.indexOf("<svg") == -1 && this.innerHTML.indexOf("<input") == -1){
				arrayUnmodify[counter] = this.innerHTML;
				this.innerHTML = "<input type='text' style='width:calc(" + $(this).css("width") + " - 20px);' value='" + this.innerHTML + "' />";
				modifyState = "selected";
				lastIndex = me;
		    }else if ( this.innerHTML.indexOf("data-mac") > 0 && this.innerHTML.indexOf("<span") == -1){
				arrayUnmodify[counter] = this.innerHTML;
				this.innerHTML = "<span style='display:none;'></span><input type='text' data-mac='" + $(this).children("a").data("mac") + "' style='width:calc(" + $(this).css("width") + " - 20px);' value='" + $(this).children("a").data("mac") + "' />";
				modifyState = "selected";
				lastIndex = me;
			}else if(this.innerHTML.indexOf("<a href") == -1 && this.innerHTML.indexOf("<svg") == -1){
				//this.innerHTML = $(this).children("input").val();
				this.innerHTML = arrayUnmodify[counter];
			}else if(this.innerHTML.indexOf("<span") == 0){
				$(this).append(rrayUnmodify[counter]);
			}
			counter++;
		});
	}
	function save(event, me, ID){
		event.preventDefault();
		var array = [];
		$(me).parent().parent().children().each(function(){
			if(this.innerHTML.indexOf("<a href") == -1 && this.innerHTML.indexOf("<svg") == -1 && this.innerHTML.indexOf("<input") == 0){
				var value = $(this).children("input").val();
				array.push(value);
				this.innerHTML = value;
				modifyState = "deselected";
			}else if ( this.innerHTML.indexOf("<span") == 0){
				var value = $(this).children("input").val();
				array.push(value);
				$(this).empty();
				if (value != "" && value != "NULL"){
					$(this).append("<a href=\"\" data-mac=\"" + value + "\" onclick=\"wake(event, this, '" + value + "', '" + array[1] + "')\" ><i class=\"fa fa-clock-o fa-2x\" aria-hidden=\"true\" ></i></a>");
				}else{
					$(this).append("<a href=\"\" data-mac=\"" + value + "\" onclick=\"wake(event, this, '" + value + "', '" + array[1] + "')\" style=\"color:black;pointer-events: none;pointer:none;\" ><i class=\"fa fa-clock-o fa-2x\" aria-hidden=\"true\" ></i></a>");
				}
				modifyState = "deselected";
			}else if(this.innerHTML.indexOf("<a href") == -1 && this.innerHTML.indexOf("<svg") == -1 && this.innerHTML.indexOf("<input") == -1){
				array.push(this.innerHTML);
			}
		});
		if (array.length > 0 ){
			if(array[2].toLowerCase() == "true"){
				array[2] = 0;
			}else{
				array[2] = 1;
			}
			$.post( "updateserver.php", { name: array[0], ipaddress: array[1], dhcp: array[2], type: array[3], OS: array[4], vmip: array[5], wakeonlan: array[8], description: array[6], comment: array[7], ID: ID }).done(function( data ) {
				if(data == "success"){
					$("body").prepend("<div id=\"overlay\"></div><div id=\"alert\">Update Successful<br><br><br><button id=\"alertbtn\" onclick=\"$('#overlay').remove();$('#alert').remove();\">[ close ]</button></div>");
					$("#alertbtn").focus();
				}else{
					$("body").prepend("<div id=\"overlay\"></div><div id=\"alert\">"+data+"<br><br><br><button id=\"alertbtn\" onclick=\"$('#overlay').remove();$('#alert').remove();\">[ close ]</button></div>");
					$("#alertbtn").focus();
				}
			});
		}
	}
	function remove(event, me, ID){
		event.preventDefault();
		$.post( "deleteserver.php", {ID: ID }).done(function( data ) {
				if(data == "success"){
					$("body").prepend("<div id=\"overlay\"></div><div id=\"alert\">Deletion was Successful<br><br><br><button id=\"alertbtn\" onclick=\"$('#overlay').remove();$('#alert').remove();\">[ close ]</button></div>");
					$("#alertbtn").focus();
					$(me).parent().parent().remove();
				}else{
					$("body").prepend("<div id=\"overlay\"></div><div id=\"alert\">"+data+"<br><br><br><button id=\"alertbtn\" onclick=\"$('#overlay').remove();$('#alert').remove();\">[ close ]</button></div>");
					$("#alertbtn").focus();
				}
		});
	}
	function wake(event, me, mac, ip){
		event.preventDefault();
		if (mac != '' && mac != 'NULL'){
			$.post( "wakeonlan.php", {mac: mac, ip: ip }).done(function( data ) {
				if(data != "fail"){
					$("body").prepend("<div id=\"overlay\"></div><div id=\"alert\">Waking System!<br>"+data+"<br><br><br><button id=\"alertbtn\" onclick=\"$('#overlay').remove();$('#alert').remove();\">[ close ]</button></div>");
					$("#alertbtn").focus();
				}else{
					$("body").prepend("<div id=\"overlay\"></div><div id=\"alert\">"+data+"<br><br><br><button id=\"alertbtn\" onclick=\"$('#overlay').remove();$('#alert').remove();\">[ close ]</button></div>");
					$("#alertbtn").focus();
				}
			});
		}
	}
</script>
</html>
