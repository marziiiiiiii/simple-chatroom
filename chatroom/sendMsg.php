<?php
if (!empty($_POST["sendmsg"])) {
  $con = mysqli_connect("localhost", "root", "", "chat");
  if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_POST["sendmsg"] == "txt") {
    $txtmsg = $_POST['txtmsg'];
    $user = $_COOKIE["user"];
    $dest = $_COOKIE["dest"];

    $sql = "INSERT INTO msgs (source, destination, sendTime, textMsg, seen)
            		VALUES ('" . $user . "', '" . $dest . "' ,  now(), '" . $txtmsg . "', false)";


    if (mysqli_query($con, $sql)) {
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
  } else if ($_POST['sendmsg'] == "vc") {
    echo $_POST["sendmsg"];
    $path = "uploads/";
    $valid_formats1 = array("mp3", "ogg", "flac");
    $file1 = $_FILES['file']['name']; //input file name in this code is file1
    $size = $_FILES['file']['size'];

    if (strlen($file1)) {
      list($txt, $ext) = explode(".", $file1);
      if (in_array($ext, $valid_formats1)) {
        $actual_image_name = $txt . "." . $ext;
        $tmp = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($tmp, $path . $actual_image_name)) {
          //success upload
        } else
          echo "failed";
      }
    }
  }

  $con->close();
  header('Location: chat.php');
}
