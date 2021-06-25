<html>

<body>

    <?php


    $expire = time() - 3600;
    setcookie("user", $_COOKIE["user"], $expire);
    setcookie("signedin", "1", $expire);
    header('Location: signin.php');
    ?>

</body>

</html>