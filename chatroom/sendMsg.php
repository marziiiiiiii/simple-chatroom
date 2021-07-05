<?php
if (!empty($_POST["sendmsg"])) {
  $con = mysqli_connect("localhost", "root", "", "chat");
  if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $user = $_COOKIE["user"];
  $dest = $_COOKIE["dest"];
  if ($_POST["sendmsg"] == "txt") {
    $txtmsg = $_POST['txtmsg'];

    $sql = "INSERT INTO msgs (source, destination, sendTime, textMsg, seen)
            		VALUES ('" . $user . "', '" . $dest . "' ,  now(), '" . $txtmsg . "', false)";


    
  } else if ($_POST['sendmsg'] == "vc") {
    $path = "uploads/";
    $valid_formats1 = array("mp3", "ogg", "flac");
    $file_name = $_FILES['file']['name']; //input file name in this code is file_name
    $size = $_FILES['file']['size'];

    if (strlen($file_name)) {
      list($txt, $ext) = explode(".", $file_name);
      if (in_array($ext, $valid_formats1)) {
        $actual_audio_name = $user . "_to_" . $dest . "_" . date("Y_m_d_h_i_sa") . "." . $ext;
        echo $actual_audio_name;
        // $txt . "." . $ext;
        $tmp = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($tmp, $path . $actual_audio_name)) {
          $sql = "INSERT INTO msgs (source, destination, sendTime, voiceMsg, seen)
          VALUES ('" . $user . "', '" . $dest . "' ,  now(), '" . $actual_audio_name . "', false)";
        } else
          echo "failed";
      }
    }
  }

  if (mysqli_query($con, $sql)) {
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }

  $con->close();
  header('Location: chat.php');
}
