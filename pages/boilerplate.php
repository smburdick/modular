<?php

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
	echo '<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header" style= "max-height: 30px; display: block; margin: 0 auto;">
            <a href="../home/"><img src="../../logo/modular_logo.png" style="max-height: 45px"></img></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            
        </div>';
		// generate the navbar items
		echo '<div class="collapse navbar-collapse" id="myNavbar">';
		echo '<form class="navbar-form navbar-input-group" role="search" method="get" action="../search/search_results.php">';
		echo '
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div></form>
        ';
		echo '
			<ul class="nav navbar-nav navbar-right">';
		// search bar

		$navbar_elts = array(
			array("Upload", "../upload/"),
			array("Categories", "../categories/categories.php"),
			array("Cart", "../cart/")
		);
		foreach ($navbar_elts as $element) {
			$name = $element[0];
			$href = $element[1];
			if ($name == $active_page) { // highlight active page
				echo '<li class="active"><a href="' . $href . '">' . $name . '</a></li>';
			} else {
				echo '<li><a href="' . $href . '">'. $name . '</a></li>';
			}
		}

		// profile
		if ($active_page == 'profile') {
			$profile_active = 'class="active"';
		}
		echo '<li ' . $profile_active . '>';
		if (isset($_COOKIE['username'])){
			echo '<a href="../profile/profile.php">Profile</a>';
		} else {
			echo '<a href="../login/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>';
		}
		echo '</li>';

		echo '
				</ul>';
		echo '
			</div>
		</div>
	</nav>';
}

// TODO make this flush with the bottom of the page.
function generate_footer() {
	echo '<footer class="container-fluid text-center">
  	<p align="left">&copy 2017 Modular</p>
	</footer>';
}

?>


