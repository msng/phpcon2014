<?php
$title = 'ものすごい掲示板';

$file = dirname(__DIR__) . '/data/bbs.json';
$json = file_get_contents($file);
$messages = json_decode($json, true);

if (isset($_POST['message']) && $_POST['message'] !== '') {
    $new_message = [
        'text' => $_POST['message'],
        'posted_at' => date('Y-m-d H:i:s'),
    ];

    $messages[] = $new_message;
    $json = json_encode($messages);
    file_put_contents($file, $json);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>
<body>
<div>
    <h1><?php echo $title; ?></h1>

    <form method="post" action="">
        <div>
            <input type="text" name="message">
            <span>
                <input type="submit" value="投稿">
            </span>
        </div>
    </form>

    <ul>
        <?php
            foreach ($messages as $message) {
                echo '<li>' . htmlspecialchars($message['text']) . ' <small>'
                    . $message['posted_at'] . '</small></li>';
            }
        ?>
    </ul>
</div>
</body>
</html>
