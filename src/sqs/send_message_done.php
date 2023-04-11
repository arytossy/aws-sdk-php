<?php

// require '../aws_sdk/aws-autoloader.php';
// require '../aws.phar';
require 'phar://'.__DIR__.'/../vendor.phar.tar.gz/autoload.php';

// use Aws\Credentials\CredentialProvider;
use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;

// $provider = CredentialProvider::memoize(CredentialProvider::ini('default', '../aws_credentials'));

$client = new SqsClient([
    'region' => 'ap-northeast-1',
    'version' => '2012-11-05',
    // 'credentials' => $provider
]);

$params = [
    'QueueUrl' => 'https://sqs.ap-northeast-1.amazonaws.com/805298822126/SdkTestOnPHP.fifo',
    'MessageBody' => $_POST['message-body'],
    'MessageGroupId' => 'sdk-test',
    'MessageDeduplicationId' => uniqid()
];

$success = false;
$message = '';
try {
    $result = $client->sendMessage($params);
    // var_dump($result);
    $message = $result;
    $success = true;
} catch (AwsException $error) {
    // var_dump($error);
    $message = $error->getMessage();
    $success = false;
}

?>

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
    <p>
        <?php
            if ($success) {
                echo "Completed to send your message!";
            } else {
                echo "Failed to send your message...";
            }
        ?>
    </p>
    <p>
        <?php echo $message ?>
    </p>
    <p>
        <a href="./send_message.php"><button>One more!</button></a>
        <a href="../index.php"><button>Exit</button></a>
    </p>
</body>
</html>