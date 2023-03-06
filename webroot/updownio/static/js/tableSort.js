function sortTable(me, direction, index) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = $("table")[0];
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[index];
      y = rows[i + 1].getElementsByTagName("TD")[index];
	  
	  // If the feild is IP address's 	
	  if (index == 2){	  
		  x = ipToNumber(x.innerHTML.split("."));
		  y = ipToNumber(y.innerHTML.split("."));
	  }else{
		  x = x.innerHTML.toLowerCase();
		  y = y.innerHTML.toLowerCase();
	  }

	  // Check if the two rows should switch place:
	  if (x > y && direction == "DESC") {
		// If so, mark as a switch and break the loop:
		shouldSwitch = true;
		break;
	  }else if(x < y && direction == "ASC"){
		shouldSwitch = true;
		break;  
	  }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
  arrowDirection(me, direction, index);
}
	
function ipToNumber(array){
	for (i=0; i < 4; i++){
	   if (array[i].length == 1){
		 array[i] = "00" + array[i];
	   }else if(array[i].length == 2){
		 array[i] = "0" + array[i];   
	   }
	}
	return parseInt(array.join(""));
}

var lastSelectedSortedColumn = $("table th:nth-child(2) svg");
function arrowDirection(me, direction, index){
	if (me != lastSelectedSortedColumn){
		$(lastSelectedSortedColumn).attr("fill", "currentColor");
		lastSelectedSortedColumn = me;
	}
	$(me).attr("fill", "yellow");
	
	if (direction == "ASC"){
		$(me).attr("onclick", "javascript:sortTable(this, 'DESC', " + index + ");");
		$("table th").children().get(index -1).innerHTML = "<path fill-rule='evenodd' d='M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path fill-rule='evenodd' d='M4.646 7.646a.5.5 0 0 1 .708 0L8 10.293l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z'/><path fill-rule='evenodd' d='M8 4.5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5z'/>";
	}else{
		$(me).attr("onclick", "javascript:sortTable(this, 'ASC', " + index + ");");
		//$("table th").children().get(0).attr("onclick", "javascript:sortTable('DESC');");
		$("table th").children().get(index -1).innerHTML = "<path fill-rule='evenodd' d='M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path fill-rule='evenodd' d='M4.646 8.354a.5.5 0 0 0 .708 0L8 5.707l2.646 2.647a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 0 0 0 .708z'/><path fill-rule='evenodd' d='M8 11.5a.5.5 0 0 0 .5-.5V6a.5.5 0 0 0-1 0v5a.5.5 0 0 0 .5.5z'/>";
	}
	
}