$( document ).ready(function() {
	var date = new Date();
	var timeout = 0;
	var hoursInSeconds = ( ( 1 + date.getHours() ) %2 ) * 3600;
	var minutesInSeconds = ( 60 - date.getMinutes() ) * 60;
	var secondsPlusTimeout = ( 60 - date.getSeconds() ) + timeout;
	var sumInMilliseconds = ( hoursInSeconds + minutesInSeconds + secondsPlusTimeout ) * 1000;
	var mydate = new Date(Date.now() + sumInMilliseconds).toString();;
	console.log("Refreshing webpage @: " + mydate);
	console.log("Time until refresh in seconds: " + sumInMilliseconds/1000);
	setTimeout(function(){ 
		if(document.location.pathname == "/admin.php"){
			var result = confirm("Refresh Page to update status?");
			if (result == true){
				location.reload(); 
			}
		}else{
			location.reload(); 
		}
	}, sumInMilliseconds);
});