<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //4-2以降でも毎回接続が必要
        //$dsnの式の中にスペースを入れないこと
        
        // 【サンプル】
        //  ・データベース名：tb250400db
        //  ・ユーザー名：tb-250400
        //  ・パスワード：2ypErhHaxd
        //  の学生の場合
        
        // DB接続設定
        echo "sql始めます<br>";
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザ名';
        $password = 'パスワード' ;
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        echo "エラー発生しませんでした";
        ?>
</body>
</html> 