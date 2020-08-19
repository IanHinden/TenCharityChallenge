<?php
        include_once 'header.php';
        include_once 'includes/dbh.inc.php';
?>
	<body>
	
		<?php

		echo '<div id="passwordresetcontent">
			<div id="confirmationtext">';
			$selector = $_GET['selector'];
			$validator = $_GET['validator'];
			
			echo "Terms of Service";
		echo '</div>
			</div>';
		?>
	</body>

<?php
	include_once 'footer.php';
?>
