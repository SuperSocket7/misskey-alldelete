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
<?php
if (isset($_GET['session'])) {
    $session = $_GET['session'];
    $host = $_SERVER['HTTP_REFERER'];
    $url = $host."api/miauth/".$session."/check";
    
    function getApi($url, $params) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        $res = curl_exec($curl);
        $arr = json_decode($res, true);
        curl_close($curl);
        return $arr;
    }

    $arr = getApi($url=$url, $params=array());
    $token = $arr['token'];
    $id = $arr['user']['id'];

    if (isset($arr['token'])) {
        //echo $token;
        //echo $id;

        $url = $host."api/users/notes";
        $params = array(
            'userId' => $id,
            'limit' => 100
        );

        $arr = getApi($url=$url, $params=$params);
        $count = count($arr);
        //print_r($arr);
        $i = 0;
        $url = $host."api/notes/delete";
        if ($count == 0) {
            echo 'ノートはありません。';
        } else {
            while ($i < $count) {
                $noteId = $arr[$i]['id'];
                $params = array(
                    'i' => $token,
                    'noteId' => $noteId
                );
                getApi($url=$url, $params=$params);
                sleep(1);
                echo $host."notes/".$noteId."は削除されました。<br>";
                $i++;
            }
        }
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>