<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * */
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
?>

<?php 
$id=htmlspecialchars($_REQUEST['id'], ENT_QUOTES);
$sql=sprintf("SELECT income.*, accounts.name 
 				FROM income 
 					JOIN user_accounts ON income.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id 
 				WHERE income.id=%d",
				mysql_real_escape_string($id)
);
$recordSet=mysql_query($sql) or die(mysql_error());;
$date=mysql_fetch_assoc($recordSet);
?>

<!DOCTYPE html>
<html>
	<!-- ヘッダーここから -->
    <head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/common.css" />
        <title>my家計簿</title>
    </head>
   
    <!-- 本文ここから -->
    <body>
    
    	<!-- 見出し ここから　-->
		<div id="head">
			<h1>収入修正</h1>
		</div>
    
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>修正フォーム   ID：<?php print (htmlspecialchars($date['id'],ENT_QUOTES));?></h2>
                    <div class="control-group">
                        <form method = "POST" action = "update_action.php" class = "well">
                            	<!-- 修正記入 -->
                            	<label>金額</label>
                            	<input type = "text" name = "amount" class="span3" value="<?php print (htmlspecialchars($date['amount'],ENT_QUOTES));?>"/>
                            	<label>内容</label>
                            	<input type = "text" name = "content" class="span3" value="<?php print (htmlspecialchars($date['content'],ENT_QUOTES));?>"/>
							<label>日付</label>
                            	<input type = "text" name = "date" class="span3" value="<?php print (htmlspecialchars($date['date'],ENT_QUOTES));?>"/>
							<label>口座名</label>
							<select  name="user_accounts_id" id="user_accounts_id" class="span3" >
                            		<?php //選択肢にユーザーの口座情報を入れる?>
                            		<?php $selected=$date['user_accounts_id']?>
                            		<?php require 'function/input_user_account_name.php'; ?>
							</select>
							<?php //ID?>
                            	<input type = "hidden" name="income_id" value="<?php print(htmlspecialchars($id));?>"> 
                            	<?php //収入情報キー?>
							<input type = "hidden" name = "key" value="income" >
							<input type = "submit" value = "送信" class="btn-primary">
                        </form>
                    </div>
                    <div class="control-group">
                    	<!-- 削除ボタン -->
                        <form method= "post" action= "delete_action.php" class = "well" >
                           	<input type= "hidden" name="income_id" value="<?php print(htmlspecialchars($id, ENT_QUOTES));?>"> 
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
<?php var_dump($date);?>