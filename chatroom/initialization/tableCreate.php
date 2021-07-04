<?php
$con = mysqli_connect("localhost", "root", "", "chat");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

//---------------------------------------------

// $sql = "CREATE TABLE users
// (
// user varchar(15) NOT NULL , 
// PRIMARY KEY(user),
// pass varchar(15) NOT NULL ,
// picture BLOB 
// )";

//---------------------------------------------

$sql = "CREATE TABLE msgs
(
msgid int NOT NULL AUTO_INCREMENT , 
PRIMARY KEY(msgid),
source varchar(15) NOT NULL , 
destination varchar(15) NOT NULL ,
sendTime DATETIME,
textMsg VARCHAR(1000),
voiceMsg VARCHAR(1000),
seen boolean

)";

//---------------------------------------------


if (mysqli_query($con, $sql)) {
    echo "Table created";
} else {
    echo "Error creating table: " . mysqli_error($con);
}
mysqli_close($con);



// http://localhost/PHP/project/v3/initialization/tableCreate.php