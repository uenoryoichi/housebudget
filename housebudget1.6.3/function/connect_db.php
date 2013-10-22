<?php

$dbname = 'RuxDdBbyKM447'; // ここにはデータベースの名前をいれる
$host = 'lost-waldo.jp'; // データベースのあるドメインを指定
$user = 'RuxDdBbyKM447'; // データベースに接続するユーザー名
$password = 'Akatuka1242'; // データベースに接続するユーザーのパスワード

$link = mysql_connect($host, $user, $password) or die(mysql_error()); //mysqlの接続情報を返す
$db = mysql_select_db($dbname, $link) or die(mysql_error()); // データベースへの接続可否を返す

$sql = 'SET NAMES utf8'; // 文字コード設定のクエリ定義
mysql_query($sql, $link); // クエリの発行

?>


