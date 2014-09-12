<html>
<head></head>
<body>
<?php

$imagesPath = "/Applications/XAMPP/xamppfiles/htdocs/SAServer/public_html/back_end/images/";

$allowedExts = array("gif", "jpeg", "jpg", "png");
$extension = strtolower(end(explode(".", $_FILES["image"]["name"])));

if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/jpg")
|| ($_FILES["image"]["type"] == "image/png"))
&& ($_FILES["image"]["size"] < 1000000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["image"]["error"] > 0) {
    echo "Error: " . $_FILES["image"]["error"] . "<br>";
  } else {
    echo "Upload: " . $_FILES["image"]["name"] . "<br>";
    echo "Type: " . $_FILES["image"]["type"] . "<br>";
    echo "Size: " . ($_FILES["image"]["size"] / 1024) . " kB<br>";
    echo "Temp File: " . $_FILES["image"]["tmp_name"]."<br>";
    $imagenum = uniqid();
    if (file_exists($imagesPath . $imagenum . "." . $extension)) {
      echo $_FILES["image"]["name"] . " already exists. "; // ask user to upload again
    } else {
      move_uploaded_file($_FILES["image"]["tmp_name"],
      $imagesPath . $imagenum . "." . $extension);
      echo "Stored in: " . $imagesPath . $imagenum . "." . $extension;
    }
  }
} else {
  echo "Invalid file";
}

?>
</body>
</html>