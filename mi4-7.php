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
        
        // データの内容を変更：UPDATE
        
        // DB接続設定
        echo "sql始めます<br>";
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザ名';
        $password = 'パスワード' ;
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //bindParamの引数（:nameなど）は4-2でどんな名前のカラムを設定したかで変える必要がある。
        $id = 2; //変更する投稿番号
        $name = "駒木";
        $comment = "おはよう2"; //変更したい名前、変更したいコメントは自分で決めること
        $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        //続けて、4-6の SELECTで表示させる機能 も記述し、表示もさせる。
        //※ データベース接続は上記で行っている状態なので、その部分は不要
        $sql = 'SELECT * FROM tbtest';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }
        echo "エラー発生しませんでした";
        ?>
</body>
</html> 