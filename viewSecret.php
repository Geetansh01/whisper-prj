<?php
$secret = NULL;
$message = NULL;
$messageClass = "info";
if(isset($_GET['secret_msg_id']) && is_numeric($_GET['secret_msg_id'])){
    $host = "localhost"; // MySQL server
    $username = "root"; // MySQL username
    $password = "root"; // MySQL password
    $dbname = "whisper"; 

    $secret_msg_id = $_GET['secret_msg_id'];

    try{
        // Create a connection
        $conn = mysqli_connect($host, $username, $password, $dbname);

        if(!$conn){
            $message = "Connection failed. Please Try Later";
            $messageClass = "error";
        }
        else{
            $sql = "SELECT secret FROM secret WHERE id = $secret_msg_id"; // ⚠ SQL Injection Vulnerability: Not sanitizing the input to MySQL
            
            try{
                $result = mysqli_query($conn, $sql);
                
                if($result === false){
                    $message = "An error occurred. Please try again later.";
                    $messageClass = "error";
                }
                elseif(mysqli_num_rows($result) != 0){
                    $secret = mysqli_fetch_row($result)[0];
                    $sql = "DELETE FROM secret WHERE id = $secret_msg_id";
                    $result2 = mysqli_query($conn, $sql);
                    if($result2){
                        $message = "View it for the first and last time!";
                        $messageClass = "info";
                    }
                    else{
                        $message = "An error occurred while deleting your secret.";
                        $messageClass = "error";
                    }
                } else {
                    $message = "Unable to find that secret! Maybe it's been destroyed 🤫";
                    $messageClass = "error";
                }
            }
            catch(Exception $e){
                $message = "Error! Please try later!";
                $messageClass = "error";
            }
        }
    }
    catch(Exception $e){
        $message = "Error! Please try later!";
        $messageClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Secret</title>
    <style>
        body {
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: rgba(255,255,255,0.08);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37);
            backdrop-filter: blur(8px);
            padding: 2.5rem 2rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .secret {
            font-size: 1.3rem;
            color: #fff;
            margin: 1.5rem 0;
            word-break: break-word;
            background: rgba(0,0,0,0.18);
            border-radius: 8px;
            padding: 1rem;
        }
        .info, .error {
            color: #ffd700;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        .error {
            color: #ff4d4f;
        }
        .footer {
            margin-top: 2rem;
            font-size: 0.95rem;
            color: #bbb;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            if($secret === NULL){
                // Always show a message, either default or from PHP logic
                if($message !== NULL){
                    echo '<div class="' . $messageClass . '">' . htmlspecialchars($message) . '</div>';
                } else {
                    echo '<div class="info">Ask your friend for their 1 time Whisper Secret URL</div>';
                }
            }
            else{
                if($message !== NULL){
                    echo '<div class="' . $messageClass . '">' . htmlspecialchars($message) . '</div>';
                }
                echo '<div class="secret">'.htmlspecialchars($secret).'</div>'; // XSS safe
            }
        ?>
        <div class="footer">Whisper &copy; <?php echo date('Y'); ?></div>
    </div>
</body>
</html>