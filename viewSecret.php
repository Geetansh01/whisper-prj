<?php
$secret = NULL;
if(isset($_GET['secret_msg_id']) && is_numeric($_GET['secret_msg_id'])){
    $host = "localhost"; // MySQL server
    $username = "root"; // MySQL username
    $password = "root"; // MySQL password
    $dbname = "whisper"; 

    $secret_msg_id = $_GET['secret_msg_id'];

    // Create a connection
    $conn = mysqli_connect($host, $username, $password, $dbname);

    if(!$conn){
        die("Connection failed. Please Try Later");
    }
    // else{
    //     echo "Connected successfully to MySQL DB";
    // }

    $sql = "SELECT secret FROM secret WHERE id = $secret_msg_id"; // ⚠ SQL Injection Vulnerability: Not sanitizing the input to MySQL
    
    try{
        $result = mysqli_query($conn, $sql);
        
        if($result === false){
            echo "An error occurred. Please try again later.";
        }
        elseif(mysqli_num_rows($result) != 0){
            $secret = mysqli_fetch_row($result)[0];
            $sql = "DELETE FROM secret WHERE id = $secret_msg_id";
            $result2 = mysqli_query($conn, $sql);
            if($result2){
                echo "View it for the first and last time!";
            }
            else{
                echo "An error occurred while deleting your secret.";
            }
        } else {
            echo "Unable to find that secret! Maybe it's been destroyed 🤫";
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
    <title>View Secret</title>
</head>
<body>
    <div> 
        <?php
            if($secret === NULL){
                echo "Ask your friend for their 1 time Whisper Secret URL";
            }
            else{
                echo $secret; // ⚠ XSS Vulnerability: Directly printing to browser
            }
        ?>
    </div>
</body>
</html>