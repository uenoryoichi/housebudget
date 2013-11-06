<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * メモ
 * マスタ利用時修正必要
 * 
 * 
 */


//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ここまで
?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>

	<!-- 見出し ここから　-->
	<div id="head">
		<h1>登録完了</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	<!-- insert部ここから -->
	<div class="col-md-offset-3 col-md-6">
		<div class="jumbotron" >
  			<h1>ようこそ！</h1>
  			<br>
  			<p>my家計簿はデバイスにかかわらず使える家計簿として、幅広い使い方ができるように開発を行っています。</p>
  			<p><a href="index.php" class="btn btn-primary btn-lg">ログインする</a></p>
		</div>
	</div>
	
<!--  <div id="content">
	<div class = "center">
		<br>
		<br>
		<h3>ユーザー登録が完了しました</h3>
		<br>
		<br>
		 <h2>
		 	<a href="index.php" class="btn btn-primary">ログインする</a>
		 </h2>
  	</div>
</div>
-->
	<!-- insert部ここまで -->
	
	
        
</body>
</html>

