<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS SDK TEST</title>
</head>
<body>
    <h2>SQS TEST - Sending Message</h2>
    <hr>
    <form action="./send_message_done.php" method="post">
        <p>
            <h3>Message Body</h3>
            <input type="text" name="message-body">
        </p>
        <p>
            <button type="submit">Send!</button>
        </p>
    </form>
    <hr>
    <a href="../index.php"><button>Exit</button></a>
</body>
</html>