<?php
// Initialize variable for the inserted secret message ID
$secret_msg_id = NULL;

if(isset($_POST['secret_msg'])){
    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "whisper"; 

    try{
        // Establish MySQL connection
        $conn = mysqli_connect($host, $username, $password, $dbname);
    
        if(!$conn){
            die("Connection failed. Please Try Later");
        }
    
        $secret_msg = $_POST['secret_msg'];
    
        $sql = "INSERT INTO secret (secret) VALUES ('$secret_msg');"; // ⚠ SQL Injection Vulnerability: Not sanitizing the input to MySQL
    
        try{
            $result = mysqli_query($conn, $sql);
            if($result){
                // Get the ID of the newly inserted secret
                $secret_msg_id = mysqli_insert_id($conn);
            } else {
                echo "Error inserting data. Please Try Later";
            }
        }
        catch(Exception $e){
            echo "Error! Please try later!";
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
    <style>
        body {
            background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: rgba(255,255,255,0.85);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.17);
            padding: 2.5rem 2rem;
            max-width: 420px;
            width: 100%;
            text-align: center;
        }
        .share-link {
            font-size: 1.1rem;
            color: #333;
            background: #f3f3f3;
            border-radius: 8px;
            padding: 1rem;
            margin: 1.2rem 0;
            word-break: break-all;
            display: inline-block;
        }
        .copy-btn {
            background: #66a6ff;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1.2rem;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }
        .copy-btn:hover {
            background: #4e8edb;
        }
        .footer {
            margin-top: 2rem;
            font-size: 0.95rem;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Share your secret link</h2>
        <p>
            <?php
                // Show the one-time secret link if available
                if ($secret_msg_id !== NULL) {
                    $url = "http://localhost:8000/viewSecret.php?secret_msg_id=$secret_msg_id";
                    echo "<span class='share-link' id='secretUrl'>$url</span>";
                    echo "<br><button class='copy-btn' onclick='copyUrl()'>Copy Link</button>";
                }
            ?>
        </p>
        <div class="footer">Whisper &copy; <?php echo date('Y'); ?></div>
    </div>
    <script>
        // Copy the secret link to clipboard
        function copyUrl() {
            var url = document.getElementById('secretUrl').innerText;
            navigator.clipboard.writeText(url).then(function() {
                const btn = document.querySelector('.copy-btn');
                btn.innerText = 'Copied!';
                setTimeout(() => btn.innerText = 'Copy Link', 1200);
            });
        }
    </script>
</body>
</html>