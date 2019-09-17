<?php
        include_once 'header.php';
        include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html>
<body>
<br><br><br><br><br>
<form action="testfileupload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
