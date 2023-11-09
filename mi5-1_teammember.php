ディレクトリ一覧 
.
 
ファイル一覧 
mission_5-1.php
 
行番号

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_5-1</title>
</head>
<body>
<?php
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザ名';
    $password = 'パスワード' ;
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS tb (
            id INT AUTO_INCREMENT PRIMARY KEY,
        name CHAR(32),
        comment TEXT,
        date DATETIME,
        pass TEXT
    )";
    $stmt = $pdo->query($sql);

    //編集
    if (!empty($_POST["edit"])) {
            $sql = 'SELECT * FROM tb';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
       if ($row["id"] == $_POST["edit"]  &&  $row["pass"] == $_POST["editpass"]){
           $editnum = $row["id"];
           $editname = $row["name"];
           $editcomment = $row["comment"];
   }
        }    
    }
    if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])) {
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $date = date("Y/m/d H:i:s");
            $pass = $_POST["pass"];
        //新規投稿
        if (empty($_POST["editNO"])) {
       $sql = "INSERT INTO tb (name, comment,date,pass) VALUES (:name, :comment, :date, :pass)";
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
       $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
       $stmt->bindParam(':date', $date, PDO::PARAM_STR);
       $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
       $stmt->execute(); 


        } else {
       $id = $_POST["editNO"];
       $sql = 'UPDATE tb SET name=:name, comment=:comment, date=:date, pass=:pass WHERE id=:id';
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
       $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
       $stmt->bindParam(':date', $date, PDO::PARAM_STR);
       $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
       $stmt->execute();

        }
    }
    //削除
    if (!empty($_POST["delete"]) && !empty($_POST["deletepass"])) {
            $delete = $_POST["delete"];
            $deletepass = $_POST["deletepass"];
            $sql = 'DELETE FROM tb WHERE id = :id AND pass = :deletepass';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
            $stmt->bindParam(':deletepass', $deletepass, PDO::PARAM_STR);
            $stmt->execute();
    } 
?>    
<form action = "" method = "post">
        <input type = "hidden" name = "editNO" value = "<?php if(isset($editnum)) {echo $editnum;} ?>"><br>
    【投稿フォーム】<br>
    <input type = "text" name = "name" placeholder = "名前" value = "<?php if(isset($editname)) {echo $editname;} ?>"><br>
    <input type = "text" name = "comment" placeholder = "コメント" value = "<?php if(isset($editcomment)) {echo $editcomment;} ?>"><br>
    <input type = "text" name = "pass" placeholder = "パスワード" value = "<?php if(isset($editpass)) {echo $editpass;} ?>">
    <input type = "submit" name = "submit" value = "送信"><br><br>
    【削除フォーム】<br>
    <input type = "text" name = "delete" placeholder = "削除番号"><br>
    <input type = "text" name = "deletepass" placeholder = "パスワード">
    <input type = "submit" name = "delete" value = "削除"><br><br>
    【編集フォーム】<br>
    <input type = "text" name = "edit" placeholder = "編集番号"><br>
    <input type = "text" name = "editpass" placeholder = "パスワード">
    <input type = "submit" value = "編集"><br><br>
</form>

<?php
    //表示
    $sql = 'SELECT * FROM tb';

$stmt = $pdo->query($sql);

    $results = $stmt->fetchAll();

    foreach ($results as $row){


    echo $row['id'].' _ '.$row['name'].' _ '.$row['comment'].' _ '.$row['date'].'<br>';

        echo "<hr>";

    }

?>
</body>
</html>