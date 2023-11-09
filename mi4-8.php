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
        
        // データの削除：DELETE
        
        // DB接続設定
        echo "sql始めます<br>";
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザ名';
        $password = 'パスワード' ;
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $id = 4; //削除番号選択
        $sql = 'delete from tbtest where id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "エラー発生しませんでした";
        $sql = 'SELECT * FROM tbtest';
        $stml = $pdo->query($sql);
        $results = $stml->fetchAll();
        //続けて、4-6の SELECTで表示させる機能 も記述し、表示もさせる。
        //※ データベース接続は上記で行っている状態なので、その部分は不要
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }
        ?>
</body>
</html> 