<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Misskeyの黒歴史クリーナー!</title>
</head>
<body>
<h2 class="m-2">Misskeyの黒歴史クリーナー!</h2>
<p style="color: red;">このツールを使用してもActivityPubの仕様上、連合先にコピーされた投稿などを完全に消すことはできません！</p>
<p style="color: red;">このツールは、削除のたびに1秒ほどsleepを入れてるけど、連合先に負荷がかかりそうなので何度も使ったりするのはおすすめしません。</p>
<form method="post">
    <label for="instance">インスタンス名</label>
    <input type="text" class="form-control m-2" name="instance">
    <input type="submit" class="btn btn-primary m-2" value="ログイン">
</form>
<?php
if ($_POST) {
    require("config.php");
    $username = $_POST['username'];
    $instance = $_POST['instance'];

    // https://www.uuidgenerator.net/dev-corner/php を参照
    function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    $uuid = guidv4();
    $url = "https://".$instance."/miauth/".$uuid."?name=Misskeyの黒歴史クリーナー!&callback=https://".hostname."/callback.php&permission=read:account,write:notes";
    header('Location: '.$url.'');
    echo $url;
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>