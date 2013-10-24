<?php

/*
 * バージョン管理
* 1.6.2
*
*
*
*/
session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
?>

<?php 
$id=htmlspecialchars($_POST['id'], ENT_QUOTES);
$sql=sprintf("SELECT pay.*, accounts.name 
 				FROM pay 
 					JOIN user_accounts ON pay.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id 
				WHERE pay.id=%d",
			mysql_real_escape_string($id)
);
$result=mysql_query($sql,$link);
$date=mysql_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
	<!-- ヘッダーここから -->
	<head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/common.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>my家計簿</title>
	</head>
    <!-- ヘッダーここまで -->
    
    <!-- 本文ここから -->
    <body>
    	<!-- 見出し ここから　-->
		<div id="head">
		　	<h1>支払修正</h1>
		</div>
		<!-- 見出し　ここまで　-->
        
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>修正フォーム   ID：<?php print (htmlspecialchars($date['id'],ENT_QUOTES));?></h2>
                    <div class="control-group">
                        <form method = "POST" action = "update_action.php" class = "well">
                            <!-- idのインプット -->
                            <input type = "hidden" name="pay_id" value="<?php print(htmlspecialchars($id));?>"> 
                            <!-- 修正記入 -->
                            <label>金額</label>
                            <input type = "text" name = "how_much" class="span3" value="<?php print (htmlspecialchars($date['how_much'],ENT_QUOTES));?>"/>
                            <label>内容</label>
                            <input type = "text" name = "what" class="span3" value="<?php print (htmlspecialchars($date['what'],ENT_QUOTES));?>"/>
							<label>日付</label>
                            <input type = "text" name = "date" class="span3" value="<?php print (htmlspecialchars($date['date'],ENT_QUOTES));?>"/>
							<label>支払い</label>
							<select  name="user_account_id" id="user_account_id" class="span3" >
								<?php //選択肢にユーザーの口座情報を入れる?>
								<?php $selected=$date['user_accounts_id']?>
                           		<?php require 'function/input_user_account_name.php'; ?>
 
							</select>
							
							<label>分類</label>
                            <input type = "text" name = "type" class="span3" value="<?php print (htmlspecialchars($date['type'],ENT_QUOTES));?>"/>
                           	<input type = "hidden" name = "key" value="pay" >
							<!-- 送信ボタン -->
							<input type = "submit" value = "送信" class="btn-primary">
                        </form>
                    </div>
                    <div class="control-group">
                    	<!-- 削除ボタン -->
                        <form method= "post" action= "delete_action.php" class = "well" >
                           	<input type= "hidden" name="pay_id" value="<?php print(htmlspecialchars($id, ENT_QUOTES));?>"> 
                           	<input type= "submit" value= "この項目を削除" class="btn-primary" onclick="return confirm('削除してよろしいですか');">
                        </form>
                    </div>
					<!-- トップ戻る -->
                    <div class = "center">
						<a href="index.php">Back To TOP</a>
					</div>
                </div>
            </div>
        </div>
    </body>
</html>
