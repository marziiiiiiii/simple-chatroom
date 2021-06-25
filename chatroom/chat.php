<html>

<head>
  <link rel="stylesheet" href="chat.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">

  <!-- <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'> -->
</head>
<script src="chat.js"></script>

<body>

  <?php
  if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1') {

    $con = mysqli_connect("localhost", "root", "", "chat");
    if ($con->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users  ";
    $result = $con->query($sql);


    if ($result->num_rows > 0) {
      // output data of each row
      $list = "";
      while ($row = $result->fetch_assoc()) {


        if ($row["user"] != $_COOKIE["user"]) {

          $list = $list . '<li>
          <img  src="data:image/jpeg;base64,' . base64_encode($row["picture"]) . '"/>';

          $list = $list .  "<div class='about'>
              <div class='name'> " . $row["user"] . " </div>
              <div class='status'>last seen recently</div>
            </div>
          </li> "; //. " " . $row["picture"] . "<br>";
        } else {
          $myavatar = '<img  src="data:image/jpeg;base64,' . base64_encode($row["picture"]) . '"/>';

        }
      }
      // echo $list;
    } else {
      echo "0 results";
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
          <div class="myname"><?php echo $_COOKIE["user"] ?></div>
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
        <!-- <li class="">
          <img src="./resourses/2.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Aiden Chavez</div>
            <div class="status">last seen recently</div>
          </div>
        </li>

        <li class="">
          <img src="./resourses/3.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Mike Thomas</div>
            <div class="status">last seen recently</div>
          </div>
        </li>

        <li class="">
          <img src="./resourses/4.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Erica Hughes</div>
            <div class="status">last seen recently</div>
          </div>
        </li>

        <li class="">
          <img src="./resourses/5.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Ginger Johnston</div>
            <div class="status">last seen recently</div>
          </div>
        </li>

        <li class="">
          <img src="./resourses/6.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Ginger Johnston</div>
            <div class="status">last seen recently</div>
          </div>
        </li>
        <li class="">
          <img src="./resourses/7.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Ginger Johnston</div>
            <div class="status">last seen recently</div>
          </div>
        </li> -->
      </ul>
    </div>
  </div>
  <div class="msger">
    <header class="msger-header">
      <div class="msger-header-title">
        <i class="fas fa-comment-alt"></i> SMSM messenger
      </div>
      <div class="msger-header-options">
        <span><i class="fa fa-cog"></i></span>
      </div>
    </header>

    <main class="msger-chat">
      <div class="msg left-msg">
        <div class="msg-img" style="background-image: url(./resourses/1.jpg)"></div>

        <div class="msg-bubble">
          <div class="msg-info">
            <div class="msg-info-name">Mahsa</div>
            <div class="msg-info-time">12:45</div>
          </div>

          <div class="msg-text">
            Hi, welcome to SimpleChat! Go ahead and send me a message. 😄
          </div>
        </div>
      </div>

      <div class="msg right-msg">
        <div class="msg-img" style="background-image: url(./resourses/2.jpg)"></div>

        <div class="msg-bubble">
          <div class="msg-info">
            <div class="msg-info-name">Marzieh</div>
            <div class="msg-info-time">12:46</div>
          </div>

          <div class="msg-text">You can change your name in JS div!</div>
        </div>
      </div>
    </main>

    <form class="msger-inputarea">
      <input type="text" class="msger-input" placeholder="Enter your message..." />


      <button type="submit" class="msger-record-btn"><i class="fa fa-microphone"></i></button>
      <button type="submit" class="msger-send-btn"><i class="fa fa-send"></i></button>
    </form>
  </div>
</body>

</html>