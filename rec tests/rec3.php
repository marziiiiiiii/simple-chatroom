<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/png" href="https://cdn.jsdelivr.net/gh/xiangyuecn/Recorder@latest/assets/icon.png">

    <title>Recorder</title>
    <script type="text/javascript" src="js/jquery.1.11.js?v=231583415054"></script>
    <script src="https://cdn.jsdelivr.net/gh/xiangyuecn/Recorder@latest/recorder.mp3.min.js"></script>

</head>

<?php

header("Content-Type:multipart/form-data;charset=utf8");
header("Access-Control-Allow-Origin: *"); //Resolve cross-domain
header('Access-Control-Allow-Methods:POST'); // Response type  
mysql_query("SET NAMES utf8"); //Solve the Chinese garbled problem
$con = mysql_connect("localhost", "root", "root");
mysql_select_db("demo", $con); //Select database


$name = $_FILES['file']['name'];
echo $_POST[id] . $name;

$result = @mysql_query($strsql);


$sql = "insert into audio (a_id,a_name) values('$_POST[id]','$name')";

if (!mysql_query($sql, $con)) {
    die('Error: ' . mysql_error());
}

move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);

echo "upload/" . $_FILES["file"]["name"];
mysql_close($con);

?>




<body>
    <script>
        var TestApi = 'http://localhost/audio/up.php'; //Used to see the request data in the console network, the test request result is irrelevant
        var rec = Recorder();
        rec.open(function() {
            rec.start();
            setTimeout(function() {
                rec.stop(function(blob, duration) {
                    //-----↓↓↓The following is the main code↓↓↓-------

                    // https://github.com/xiangyuecn/Recorder

                    //This example assumes that the request method encapsulated by jQuery is used. In actual use, adjust it to your own request method
                    //Get the blob file object at the end of the recording, you can use FileReader to read the content, or use FormData to upload
                    var api = TestApi;

                    /***Method 2: Use FormData to upload files with multipart/form-data forms***/
                    var form = new FormData();
                    form.append("file", blob, "recorder.mp3"); //It is the same as a normal form, the backend receives the file with the upfile parameter, the file name is recorder.mp3
                    form.append("id", "1");
                    //...Other form parameters
                    $.ajax({
                        url: api //Upload interface address
                            ,
                        type: "POST",
                        contentType: false //Let xhr automatically process Content-Type header, multipart/form-data needs to generate random boundary
                            ,
                        processData: false //Do not process data, let xhr handle it automatically
                            ,
                        data: form,
                        success: function(v) {
                            console.log("Upload successful", v);
                        },
                        error: function(s) {
                            console.error("Upload failed", s);
                        }
                    });

                    //-----↑↑↑The above is the main code↑↑↑-------
                }, function(msg) {
                    console.log("Recording failed:" + msg);
                });
            }, 1000);
        }, function(msg) {
            console.log("Cannot record:" + msg);
        });
    </script>
</body>

</html>