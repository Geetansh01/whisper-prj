<?php
$secret_msg_id = NULL;
if(isset($_POST['secret_msg'])){
    $host = "localhost"; // MySQL server
    $username = "root"; // MySQL username
    $password = "root"; // MySQL password
    $dbname = "whisper"; 

    // Create a connection
    $conn = mysqli_connect($host, $username, $password, $dbname);

    if(!$conn){
        die("Connection failed. Please Try Later");
    }
    // else{
    //     echo "Connected successfully to MySQL DB";
    // }

    $secret_msg = $_POST['secret_msg'];

    $sql = "INSERT INTO secret (secret) VALUES ('$secret_msg');"; // ⚠ SQL Injection Vulnerability: Not sanitizing the input to MySQL

    try{

        $result = mysqli_query($conn, $sql);
        if($result){
            $secret_msg_id = mysqli_insert_id($conn);
        } else {
            echo "Error inserting data. Please Try Later";
        }
    }
    catch(Exception $e){
        echo "Error! Please try later!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Time Share Link</title>
</head>
<body>
    <p>
        <?php
            if ($secret_msg_id !== NULL) {
                echo "Your 1 time Whisper URL is: http://localhost:8000/viewSecret.php?secret_msg_id=$secret_msg_id";
            }
        ?>
    </p>
</body>
</html>