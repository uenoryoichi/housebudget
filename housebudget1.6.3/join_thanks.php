<?php
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
require 'function/connect_housebudget.php';
//関数設定
require 'library_all.php';

?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>登録完了</h1>
	</div>
	
	<div class="col-md-offset-3 col-md-6">
		<div class="jumbotron" >
  			<h1>ようこそ！</h1>
  			<br>
  			<p>my家計簿はデバイスにかかわらず使える家計簿として、幅広い使い方ができるように開発を行っています。</p>
  			<p><a href="index.php" class="btn btn-primary btn-lg">ログインする</a></p>
		</div>
	</div>
        
</body>
</html>

