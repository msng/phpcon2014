<?php
/**
 * PHP 入門の何かで掲示板のようなものを作るときのサンプル
 *
 * @todo: ファイル読み書きの排他処理
 */

//ログファイルのパスを設定
$log_dir = dirname(__DIR__) . '/data';
$log_filename = 'bbs.json';
$log_path = $log_dir . '/' . $log_filename;

$title_for_page = '何かすごい掲示板';

//ログファイルが存在すれば読み込む
if (file_exists($log_path)) {
    $json = file_get_contents($log_path);
    $messages = json_decode($json, true);
} else {
    $messages = [];
}

//新規投稿があれば取り出して書き込む
if (isset($_POST['message']) && $_POST['message'] !== '') {
    $new_message = [
        'text' => $_POST['message'],
        'posted_at' => date('Y-m-d H:i:s')
    ];
    $messages[] = $new_message;
    $message_json = json_encode($messages);
    file_put_contents($log_path, $message_json);
}

//新しいメッセージが上に来るように並べ替え
$messages = array_reverse($messages);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title_for_page; ?></title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>
<body>
<div class="container">
    <h1><?php echo $title_for_page; ?></h1>

    <form method="post" action="">
        <div class="input-group form-group">
            <input type="text" name="message" class="form-control">
            <span class="input-group-btn">
                <input type="submit" value="投稿" class="btn btn-primary">
            </span>
        </div>
    </form>

    <ul class="list-group">
        <?php
        if (isset($messages)) {
            foreach ($messages as $message) {
                echo '<li class="list-group-item">' . htmlspecialchars($message['text']) . ' <small class="text-muted pull-right">' . $message['posted_at'] . '</small></li>';
            }
        }
        ?>
    </ul>
</div>
</body>
</html>
