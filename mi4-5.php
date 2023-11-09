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
        
        // データ登録
        
        // DB接続設定
        echo "sql始めます<br>";
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザ名';
        $password = 'パスワード' ;
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $name = '魚住';
        $comment = 'おはよう5';
        
        $sql = 'Insert into tbtest(name, comment) VALUES(:name, :comment)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
    //bindParamの引数名（:name など）はテーブルのカラム名に併せるとミスが少なくなります。最適なものを適宜決めよう。
        echo "エラー発生しませんでした";
        ?>
</body>
</html> 