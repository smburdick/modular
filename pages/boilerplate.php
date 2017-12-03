<?php

// TODO these are for pages in directories of the form pages/[name]
 // i => (DisplayName, href) 

function generate_head($page_name, $active_page) {
	echo '<head>';
	echo '<title>' . $page_name . '</title>';
	echo '<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "../css/style.css" /> ';
	echo '</head>';
	echo '<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="../">Modular</a>
		</div>';
		// generate the navbar items 
		echo '
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">';
				// search bar
		echo '<li><form class="navbar-form" role="search" method="get" action="search/search_results.php">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form></li>';
		// TODO navbar items
		$navbar_elts = array(
			array("Upload", "../upload/"),
			array("Categories", "../categories/"),
			array("Cart", "../cart/")
		);
		foreach ($navbar_elts as $element) {
			$name = $element[0];
			$href = $element[1];
			if ($name == $active_page) {
				echo '<li class="active"><a href="' . $href . '">' . $name . '</a></li>';
			} else {
				echo '<li><a href="' . $href . '">'. $name . '</a></li>';
			}
		}
		
		echo '	</ul>
			<ul class="nav navbar-nav navbar-right">';
					if (isset($_COOKIE['username'])){
						echo '<li><a href="../profile/profile.php">Profile</a></li>';
					}else{
						echo '<li><a href="../login/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
					}
			echo '
				</ul>
			</div>
		</div>
	</nav>';
}

// TODO make this flush with the bottom of the page.
function generate_footer() {
	echo '<footer class="container-fluid text-center">
  	<p align="left">2017 Modular</p>
	</footer>';
}

?>


