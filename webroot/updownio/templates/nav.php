 <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  
  <div class="collapse navbar-collapse" id="navbarCollapse">
<ul class="navbar-nav mr-auto">
<li><a class="nav-link" href="/updownio">Home</a></li>
<?php 
	// Only show admin link, if the user is authenticaticated
	if (isset($_SESSION['authenticated'])) {
      echo "<li class=\"nav-item\">";
      echo "   <a class=\"nav-link\" href=\"admin.php\">Admin</a>";
      echo "</li>";
	}
  ?>
</ul>
<?php
	// Show logout link if the user is authenticaticated else show login link 
	if (isset($_SESSION['authenticated'])) {
    echo "<a href=\"logout.php\"><span class=\"navbar-text\">Logout " . $_SESSION['username'] . "</span></a>";
	}else{
    echo "<a href=\"login.php\"><span class=\"navbar-text\">Login</span></a>";
  }
?>
  </div>
</nav>
