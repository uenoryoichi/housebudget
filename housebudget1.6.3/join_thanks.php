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
<html>
	<head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/common.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>my家計簿</title>
	</head>

	<!-- 本文　ここから -->
	
	<!-- 見出し ここから　-->
	<div id="head">
		<h1>登録</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	<!-- insert部ここから -->
    <body>
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>ユーザー登録が完了しました</h2>
                    <div class="control-group">
                    	<div><a href="index.php">ログインする</a></div>
                    </div>
                </div>
            </div>
        </div>
	<!-- insert部ここまで -->
        
    </body>
</html>

