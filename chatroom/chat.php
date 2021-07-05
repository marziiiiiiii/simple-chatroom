<!-- line 17 in case <img class="msg-img" src="./resourses/4.jpg" /> -->
<!-- line 23  <div class="msg-info-name">' . $source . '</div> -->
<!-- onload="window.onload = Scrolldown;" -->

<!-- TODO style contact when select -->
<!-- TODO scroll onload 183 -->
<!-- optional delete and notif -->
<html>

<head>
  <link rel="stylesheet" href="chat.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">

</head>


<body OnLoad="document.myform.txtmsg.focus();">

  <?php
  function addTxtMsgToHTMLStr($Messags, $side, $sendTime, $textMsg)
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
  function addVcMsgToHTMLStr($Messags, $side, $sendTime, $voiceMsg)
  {
    $Messags = $Messags . '<div class="msg ' . $side . '-msg">
    
                <div class="msg-bubble">
                  <div class="msg-info">
                    <div class="msg-audio">
                    <audio controls>
                      <source src="uploads/' . $voiceMsg . '" type="audio/mpeg">
                    </audio> 
                    </div>
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

    $displayLastSeen = "";
    $Messags = "";
    $displaySend = "";
    $user = $_COOKIE["user"];
    $dest = $_COOKIE["dest"];

    //---------------------- load contacts -----------------------

    $sql = "SELECT * FROM users  ";
    $result = $con->query($sql);
    $list = "";


    if ($result->num_rows > 0) {
      $theirPicSrc = "";

      while ($row = $result->fetch_assoc()) {

        if ($row["user"] != $user) {
          if ($row["picture"] == null) {
            $theirPicSrc = "./resourses/u2.png";
          } else {
            $theirPicSrc = 'data:image/jpeg;base64,' . base64_encode($row['picture']);
          }

          $list = $list .  "<li onclick = openHistory('" . $row['user'] . "')>
              <img  src='" . $theirPicSrc . "'/>
              <div class='about'>
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
            $Messags = addTxtMsgToHTMLStr($Messags, $side, $row["sendTime"], $row["textMsg"]);
          } else {
            $Messags = addVcMsgToHTMLStr($Messags, $side, $row["sendTime"], $row["voiceMsg"]);
          }
        }
      } else {
        $Messags = "<div class='empty-history'>no history</div>";
      }
    } else {
      $displayLastSeen = "hidden";
      $displaySend = "none";
      $Messags = "<div class='empty-history'>select chat</div>";
    }

    $con->close();
  } else {
    header('Location: signinsignup.php');
  }
  ?>

  <!----------------------------------------------------------------------------------->

  <div class="list">
    <div class="people-list" id="people-list">
      <div class="profile">
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
      <div style="visibility: <?php echo $displayLastSeen ?>;">
        last seen recently
      </div>
      <div class="msger-header-title">
        <?php echo $dest ?>
      </div>
      <div>
        SMSM messenger
      </div>
    </header>

    <main id="history" class="msger-chat">
      <?php echo $Messags; ?>
    </main>

    <form name="myform" action="sendMsg.php" method="POST" enctype="multipart/form-data" class="msger-inputarea" style="display: <?php echo $displaySend ?>;">
      <input name="txtmsg" type="text" class="msger-input" placeholder="Enter your message to <?php echo $dest ?>" />
      <input type="file" name="file" id="file" accept=".ogg,.flac,.mp3"  />
      <!-- <record name="recMsg" beep="true" maxtime="120s" finalsilence="5000ms" dtmfterm="true" type="audio/basic"  /> -->


<!-- 
      <button id=startRecord onclick=startRec()>start</button>
      <button id=stopRecord onclick=stopRec() disabled>Stop</button>
 -->



      <div style="direction: rtl;">
        <button type="submit" name="sendmsg" value="txt" class="msger-send-btn">
          <i class="fa fa-send"></i>
        </button>
        <button name="sendmsg" value="vc" type="submit" class="msger-record-btn">
          <i class="fa fa-microphone"></i>
        </button>
      </div>
    </form>
  </div>


  <script src="chat.js">
  </script>
</body>

</html>