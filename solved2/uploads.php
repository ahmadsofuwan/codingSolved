<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "solved";


$target_dir = "uploads/";
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
$fileName = basename(strtotime("now") . '.' . $imageFileType);
$target_file = $target_dir . $fileName;
$uploadOk = 1;
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<script>alert('file Telah di Uploads')</script>";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $file = strtotime("now") . '.' . $imageFileType;
        $sql = "INSERT INTO uploads (id, name, title, price, note) VALUES 
        ('null', '" . $file . "','" . $_POST['title'] . "','" . $_POST['price'] . "','" . $_POST['note'] . "'  )";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
