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

$queueUrl = 'https://sqs.ap-northeast-1.amazonaws.com/805298822126/SdkTestOnPHP.fifo';

$success = false;
$message = '';
try {
    $result = $client->receiveMessage([
        'QueueUrl' => $queueUrl,
        'MaxNumberOfMessages' => 1,
    ]);
    if (empty($result->get('Messages'))) {
        $message = "No message in queue...";
    } else {
        $message = print_r($result->get('Messages')[0], true);
        $client->deleteMessage([
            'QueueUrl' => $queueUrl,
            'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle']
        ]);
    }
    $success = true;
} catch (AwsException $error) {
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
    <h2>SQS TEST - Receiving Message</h2>
    <hr>
    <p>
        <?php
            if ($success) {
                echo "Completed to receive the message!";
            } else {
                echo "Failed to receive the message...";
            }
        ?>
    </p>
    <p>
        <?php echo $message ?>
    </p>
    <p>
        <a href="./receive_message.php"><button>One more!</button></a>
        <a href="../index.php"><button>Exit</button></a>
    </p>
</body>
</html>