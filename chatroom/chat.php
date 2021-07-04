<!-- line 17 in case <img class="msg-img" src="./resourses/4.jpg" /> -->
<!-- line 23  <div class="msg-info-name">' . $source . '</div> -->

<!-- TODO style contact when select -->
<!-- TODO scroll onload 183 -->
<html>

<head>
  <link rel="stylesheet" href="chat.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">

</head>


<body>

  <?php
  function addMsgToHTMLStr($Messags, $side, $source, $sendTime, $textMsg)
  {
    $Messags = $Messags . '<div class="msg ' . $side . '-msg">
    
                <div class="msg-bubble">
                  <div class="msg-info">
                    <div class="msg-text">' . $textMsg . '</div>
                  </div>

                  <div class="msg-info-time">
                    ' . $sendTime . '
                  </div>
                </div></div>';

    return $Messags;
  }


  if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1') {

    $con = mysqli_connect("localhost", "root", "", "chat");
    if ($con->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $tempppppppppppppppppppppppppppppppp = "";
    $Messags = "";
    $displaySend = "";
    $user = $_COOKIE["user"];
    $dest = $_COOKIE["dest"];

    //---------------------- load contacts -----------------------

    $sql = "SELECT * FROM users  ";
    $result = $con->query($sql);
    $list = "";


    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {


        if ($row["user"] != $user) {
          if ($row["picture"] == null) {
            $list = $list . '<li onclick = openHistory("' . $row["user"] . '")>
            <img  src="./resourses/u2.png"/>';
          } else {
            $list = $list . '<li onclick = openHistory("' . $row["user"] . '")>
            <img  src="data:image/jpeg;base64,' . base64_encode($row["picture"]) . '"/>';
          }

          $list = $list .  "<div class='about'>
              <div class='name'> " . $row["user"] . " </div>
              <div class='status'>last seen recently</div>
            </div>
          </li> ";
        } else {
          if ($row["picture"] == null) {
            $myavatar = '<img class="myavatar" src="./resourses/u2.png"/>';
          } else {
            $myavatar = '<img class="myavatar" src="data:image/jpeg;base64,' . base64_encode($row["picture"]) . '"/>';
          }
        }
      }
    } else {
      $list = "0 contacts";
    }

    //---------------------- load history -----------------------

    if ($dest != "   ") {
      $sql = "SELECT * FROM msgs WHERE 
      source='" . $user . "' AND destination='" . $dest . "' OR 
      source='" . $dest . "' AND destination='" . $user . "'  ";
      $result = $con->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {


          if ($row["source"] == $user) {
            $side = 'right';
          } else {
            $side = "left";
          }

          if ($row["textMsg"] != null) {
            $Messags = addMsgToHTMLStr($Messags, $side, $row["source"], $row["sendTime"], $row["textMsg"]);
          } else {
          }
        }
      } else {
        $Messags = "no history";
      }

      //TODO mesle bala row haro bebar too ghaleb message html va string haro join kon
      //message to ham dar box pak kon
    } else {
      $displaySend = "none";
    }

    //---------------------- send msg -----------------------


    // if (!empty($_POST["sendmsg"]) && $_POST["sendmsg"] == "txt") {
    //   $txtmsg = $_POST['txtmsg'];

    //   $sql = "INSERT INTO msgs (source, destination, sendTime, textMsg, seen)
    // 		VALUES ('" . $user . "', '" . $dest . "' ,  now(), '" . $txtmsg . "', false)";


    //   if (mysqli_query($con, $sql)) {
    //     $tempppppppppppppppppppppppppppppppp = "New record " . $user . " to " . $dest . "=> " . $txtmsg;
    //   } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($con);
    //   }





    //   // } else if (array_key_exists('sendvc', $_POST)) {
    // } else if (!empty($_POST["sendmsg"]) && $_POST['sendmsg'] == "vc") {
    //   $tempppppppppppppppppppppppppppppppp = "This is voice that is selected";
    //   unset($_POST['sendvc']);
    // }

    //----------------------  -----------------------


    $con->close();
  } else {
    header('Location: signinsignup.php');
  }
  ?>

  <!----------------------------------------------------------------------------------->

  <div class="list">
    <div class="people-list" id="people-list">
      <div class="profile">
        <?php echo $tempppppppppppppppppppppppppppppppp ?>
        <?php echo $myavatar ?>

        <div class="about">
          <div class="myname"><?php echo $user ?></div>
          <div class="logout">
            <div class="mystatus">online</div>
            <form action="signout.php" method="GET">
              <button class="logout-btn" type="submit">logout</button>
            </form>
          </div>
        </div>

      </div>
      <ul class="people">
        <?php echo $list; ?>
      </ul>
    </div>
  </div>
  <div class="msger">
    <header class="msger-header">
      <div>
        last seen recently
      </div>
      <div class="msger-header-title">
        <?php echo $dest ?>
      </div>
      <div>
        SMSM messenger
      </div>
    </header>

    <main class="msger-chat" onload="window.onload = Scrolldown;">
      <?php echo $Messags; ?>
    </main>

    <form action="sendMsg.php" method="POST" class="msger-inputarea" style="display: <?php echo $displaySend ?>;">
      <input name="txtmsg" type="text" class="msger-input" placeholder="Enter your message to <?php echo $dest ?>" />
      <!-- <button name="sendmsg" value="vc  " type="submit" class="msger-record-btn">
        <i class="fa fa-microphone"></i>
      </button> -->
      <button type="submit" name="sendmsg" value="txt" class="msger-send-btn">
        <i class="fa fa-send"></i>
      </button>
    </form>
  </div>


  <script src="chat.js">
    // var today = new Date();
    // var time = today.getHours() + ':' + today.getMinutes();
    // document.getElementById("time").innerHTML=time;
  </script>
</body>

</html>