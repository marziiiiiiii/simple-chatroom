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
            // $tempppppppppppppppppppppppppppppppp = "New record " . $user . " to " . $dest . "=> " . $txtmsg;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }





        // } else if (array_key_exists('sendvc', $_POST)) {
    } else if ($_POST['sendmsg'] == "vc") {
        
    }


    $con->close();
  header('Location: chat.php');


}
?>