<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //ファイルの代わりにデータベースを指定
        $dsn = 'mysql:dbname=tb250400db;host=localhost';
        $user = 'tb-250400';
        $password = '2ypErhHaxd' ;
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        //テーブル作成
        $sql = 'CREATE TABLE IF NOT EXISTS tb2chan'
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name CHAR(32),"
        ."comment TEXT,"
        ."date DATETIME,"
        ."pass TEXT"
        .");";
        //作成済みテーブル
        $stmt = $pdo->query($sql);
        $sql ='SHOW TABLES';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
            echo 'テーブル名： ';
            echo $row[0];
            echo '<br>';
        }
        echo "<hr>";

        /*編集選択機能*/
        /*POST送信があった時*/
        if(isset($_POST["edit"]) && !empty($_POST["passedit"])){
            /*受信し、変数に格納*/
            $edit = $_POST["edit"];
            $passedit = $_POST["passedit"];
            //idとpassが一致する行を選択
            $sql = 'SELECT * FROM tb2chan WHERE id = :id AND pass = :passedit';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $edit, PDO::PARAM_INT);
            $stmt->bindParam(':passedit', $passedit, PDO::PARAM_STR);
            $stmt->execute();
            $edit_row = $stmt->fetch();
            if ($edit_row) {
                $edit_name = $edit_row['name'];
                $edit_comment = $edit_row['comment'];
                $edit_number = $edit;
                $edit_pass = $edit_row['pass'];
            }
        }
        /*POST送信があったとき*/
        if(!empty($_POST["comment"]) && !empty($_POST["name"]) && isset($_POST["submit"]) && !empty($_POST["password"])){
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $date = date("Y/m/d/H:i:s");
            $pass = $_POST["password"];
            /*新規投稿*/
            if(empty($_POST["editnum"])){
                //sqlにデータ登録
                $sql = 'Insert into tb2chan(name, comment, date, pass) VALUES(:name, :comment, :date, :pass)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->execute();
                echo "書き込み成功！<br>";
            } else{
                /*編集機能*/
                $editnum= $_POST["editnum"];
                //sqlに変更内容を保存
                $sql = 'UPDATE tb2chan SET name=:name,comment=:comment,date=:date,pass=:pass WHERE id =:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } elseif(!empty($_POST["comment"]) && !empty($_POST["name"]) && empty($_POST["password"])){
            echo "パスワードを入力してください";
        }
        
        /*削除機能*/
        if(isset($_POST["delete"]) && isset($_POST["delete_submit"]) && !empty($_POST["passdel"])){
            /*変数に代入*/
            $delete = $_POST["delete"];
            $passdel = $_POST["passdel"];
            //データベースから削除
            $sql = 'delete from tb2chan where id = :id AND pass = :passdel';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
            $stmt->bindParam(':passdel', $passdel, PDO::PARAM_STR);
            $stmt->execute();
        }
        ?>

    <form action="" method="post">
        [新規投稿]<br>
        <input type = "text" name = "name" placeholder = "名前を入力してください" value="<?php if(isset($edit_name)){ echo $edit_name; }?>"><br>
        <input type = "text" name = "comment" placeholder = "コメントを入力してください" value="<?php if(isset($edit_comment)){ echo $edit_comment; }?>"><br>
        <input type = "hidden" name = "editnum" value = "<?php if(isset($edit_number)){echo $edit_number;} ?>">
        <input type = "password" name = "password" placeholder ="パスワード" value = "<?php if(isset($edit_pass)){echo $edit_pass;}?>">
        <input type = "submit" name = "submit" value="投稿"><br><hr>
        [削除]<br>
        <input type = "number" name = "delete" placeholder = "削除番号を入力してください"><br>
        <input type = "text" name = "passdel" placeholder = "パスワード">
        <input type = "submit" name = "delete_submit" value = "削除"><br><hr>
        [編集]<br>
        <input type = "number" name = "edit" placeholder = "編集したい番号を入力してください"><br>
        <input type = "text" name = "passedit" placeholder = "パスワード">
        <input type = "submit" name = "edit_submit" value = "編集"><br><hr>
    </form>

    <?php
        /*出力*/
        $sql = 'SELECT * FROM tb2chan';
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
        echo "<hr>";
        }
    ?>
</body>
</html>