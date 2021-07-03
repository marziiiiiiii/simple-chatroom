<html>

<head>
  <link rel="stylesheet" href="chat.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">

</head>


<body>

  <?php
  if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1') {

    $con = mysqli_connect("localhost", "root", "", "chat");
    if ($con->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


    $displaySend = "";
    $user = $_COOKIE["user"];
    $dest = $_COOKIE["dest"];

    $sql = "SELECT * FROM users  ";
    $result = $con->query($sql);


    if ($result->num_rows > 0) {
      $list = "";
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
      echo "0 results";
    }

    if ($dest != "   ") {
      $sql = "SELECT * FROM messages WHERE src='. $user .' and dest='. $dest .' ";
      //TODO mesle bala row haro bebar too ghaleb message html va string haro join kon
      //message to ham dar box pak kon
      // echo "ksjdfkldshgjkhskgh";
    }

    $con->close();
  } else {
    header('Location: signinsignup.php');
  }
  ?>



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
      <div class="msger-header-title">
        <i class="fas fa-comment-alt"></i> SMSM messenger
      </div>
    </header>

    <main class="msger-chat">
      <div class="msg left-msg">
        <!-- <div class="msg-img" style="background-image: url(./resourses/1.jpg)"></div> -->
        <!-- <img class="msg-img" src="./resourses/4.jpg" /> -->

        <!-- <div class="msg-bubble">
          <div class="msg-info">
            <div class="msg-info-name">Mahsa</div>
            <div class="msg-info-time">fsdfds</div>
          </div>

          <div class="msg-text">
            Hi, welcome to SimpleChat! Go ahead and send me a message. 😄
          </div>
        </div> -->
      </div>

      <div class="msg right-msg">
        <!-- <div class="msg-img" style="background-image: url(./resourses/2.jpg)"></div>
        <img class="msg-img" src="./resourses/2.jpg" />

        <div class="msg-bubble">
          <div class="msg-info">
            <div class="msg-info-name"></div>
            <div class="msg-info-time" id="time"></div>
          </div>

          <div class="msg-text">You can change your name in JS div!</div>
        </div>
      </div> -->
    </main>

    <form class="msger-inputarea" style="display: <?php echo $displaySend ?>;">
      <input type="text" class="msger-input" placeholder="Enter your message to <?php echo $dest ?>" />


      <button onclick=sendvc() class="msger-record-btn"><i class="fa fa-microphone"></i></button>
      <button onclick=sendmsg() class="msger-send-btn"><i class="fa fa-send"></i></button>
    </form>
  </div>


  <script src="chat.js">
    // var today = new Date();
    // var time = today.getHours() + ':' + today.getMinutes();
    // document.getElementById("time").innerHTML=time;
  </script>
</body>

</html>