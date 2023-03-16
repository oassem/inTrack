<?php
include 'database_conf.php';
ob_start();
session_start();

if (!empty($_FILES["fileToUpload"]["name"])) {
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg');
    if (in_array($fileType, $allowTypes)) {
        $imgContent = addslashes(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
        $sql = "update lineshistory set image='" . $imgContent . "', created=NOW() where id='" . $_POST['add-image'] . "'";
        $conn->query($sql);
        $conn->close();
        header("Location: ./history.php");
    }
} else {
    echo "Sorry, there was an error uploading your file. Please make sure to upload a proper image file and try again!";
}
?>