<?php
        include_once 'header.php';
?>

<?php

echo '<br><br><br><br><form class="password-reset-form" action="includes/passwordreset.inc.php" method="POST">
			<p>Please enter your e-mail address and submit. Then follow the instructions in the e-mail to reset your password.</p>
                        <input type="text" name="email" placeholder="E-mail Address"><br>
			<button type="submit" value="submit" name="submit">Submit</button></form>';

?>
