<?php

if(isset($_POST['submit'])){
	if(!empty($_POST['friendlist'])){
// Loop to store and display values of individual checked checkbox.
		foreach($_POST['friendlist'] as $selected){
			echo $selected."</br>";
		}
	}
}

?>
