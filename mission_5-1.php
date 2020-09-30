<html lang="ja">
<head>
    <meta charset ="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
     <!--投稿フォームの作成-->
     投稿フォーム
     <br>
    <form action="" method="post">
    <input type="text" name="name" placeholder="名前">
    <input type="text" style="width:70%" name="comment" placeholder="コメント">
    <input type="text" name="password" placeholder="パスワード">
    <input type="submit" name="submit">
    <br>
    <!--削除フォーム-->
    削除フォーム
    <br>
    <input type="number" name="number"  placeholder="削除する投稿番号">
    <input type="text" name="delpass" placeholder="パスワード">
    <input type="submit" name="delete">
    <br>
     <!--投稿編集フォーム設定-->
     投稿編集フォーム<br>
        <input type="number" name="editnum" placeholder="編集する投稿番号">
        <input type="text" style="width:70%" name="editcom" placeholder="新規投稿内容">
        <input type="text"  name="editpass" placeholder="パスワード">
        <input type="submit" name="edit" placeholder="編集">
    </form>
<?php

// DB接続設定
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//dbに書き込み（4-5
if(isset($_POST["submit"])){
    //各関数の設定
    $pname=$_POST["name"];
    $pcomment=$_POST["comment"];
    $pdate=date("Y/m/d/ H:i:s");
    $ppass=$_POST["password"];
    if($pname=="" or $pcomment=="" or $ppass==""){
        echo "未送信、各項目を記入してください"."<br>";
    }else{


$sql = $pdo -> prepare("INSERT INTO mission_5 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':date', $date, PDO::PARAM_STR);
$sql -> bindParam(':pass',$pass,PDO::PARAM_STR);
$name = $pname;
$comment = $pcomment; 
$date = $pdate;
$pass = $ppass;
$sql -> execute();
}
}
//編集
if(isset($_POST["edit"])){
    //POST 
    $editnum=$_POST["editnum"];
    $editcom=$_POST["editcom"];
    $editpass=$_POST["editpass"];
//パスワード
$id = $editnum; //変更する投稿番号
 $sql='SELECT * FROM mission_5 WHERE id=:id ';
 $stmt = $pdo->prepare($sql);                 
$stmt->bindParam(':id', $id, PDO::PARAM_INT); 
$stmt->execute();                             
$results = $stmt->fetchAll();
//デッバク
//var_dump($results);
//echo $results[0]["pass"];
    if($results[0]["pass"]!==$editpass){
    echo "パスワードが違います"."<br>";
    }else{
    $comment = $editcom; //変更したい名前、変更したいコメントは自分で決めること
    $edate=date("Y/m/d/ H:i:s");
    $sql = 'UPDATE mission_5 SET comment=:comment,date=:date WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':date', $edate, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    } 
}
//削除
if(isset($_POST["delete"])){
    //POST 
    $delnum=$_POST["number"];
    $delpass=$_POST["delpass"];
//パスワード
$id = $delnum; //変更する投稿番号
 $sql='SELECT * FROM mission_5 WHERE id=:id ';
 $stmt = $pdo->prepare($sql);                 
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();                             
$results = $stmt->fetchAll();
    if($results[0]["pass"]!==$delpass){
    echo "パスワードが違います"."<br>";
    }else{
        $id = $delnum;
	$sql = 'delete from mission_5 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
}
//表示(4-6)
$sql = 'SELECT * FROM mission_5';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].',';
    echo $row['date'].'<br>';
echo "<hr>";
}

?>
</body>
</html>