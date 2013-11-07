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

<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>
    
    <!-- 本文ここから -->
<body>
    	<!-- 見出し ここから　-->
	<div id="head">
	　	<h1>支払修正</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
		<!-- update部ここから -->
   	<div class="container">
      	<div class="row">
        		<div class="col-md-offset-3 col-xs-6">
             	<br><h2>修正フォーム   ID：<?php print (htmlspecialchars($date['id'],ENT_QUOTES));?></h2>
                	<form method = "POST" action = "update_action.php" class = "form-horizontal well">
					<dl>
                		<dt>金額</dt>
                    		<dd>
                    			<input type = "text" name = "how_much" class="form-control" value="<?php print (htmlspecialchars($date['how_much'],ENT_QUOTES));?>"/>
                        	</dd>
                        	
                     	<dt>内容</dt>
                    		<dd>
                    			<input type = "text" name = "what" class="form-control" value="<?php print (htmlspecialchars($date['what'],ENT_QUOTES));?>"/>
						</dd>
						
					<dt>日付</dt>
                     		<dd>
                     			<input type = "text" name = "date" class="form-control" value="<?php print (htmlspecialchars($date['date'],ENT_QUOTES));?>"/>
						</dd>
						
					<dt>支払い</dt>
						<dd>
							<select  name="user_accounts_id" class="form-control">
							<?php //選択肢にユーザーの口座情報を入れる?>
							<?php $selected=$date['user_accounts_id']?>
                 	        	<?php require 'function/input_user_account_name.php'; ?>
 							</select>
						</dd>
						
					<dt>分類</dt>
                     		<dd>
                     			<input type = "text" name = "type" class="form-control" value="<?php print (htmlspecialchars($date['type'],ENT_QUOTES));?>"/>
                       	</dd>
                    	</dl>
                     	<div class="center">
                    		<!-- 送信ボタン -->
           				<input type = "hidden" name="pay_id" value="<?php print(htmlspecialchars($id, ENT_QUOTES));?>"> 
                	    		<input type = "hidden" name = "key" value="pay" >
						<input type = "submit" value = "修正を送信" class="btn btn-primary">
            			</div>
            		</form>
            	</div>
        	</div>
    	</div>
      	
    <!-- 削除ボタン -->
      <div class="container">
   		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="center">
               		<form method= "post" action= "delete_action.php" class = "form-horizontal well" >
            				<input type= "hidden" name="pay_id" value="<?php print(htmlspecialchars($id, ENT_QUOTES));?>"> 
           				<input type = "hidden" name = "key" value="pay" >
               			<input type= "submit" value= "この項目を削除" class="btn btn-danger" onclick="return confirm('削除してよろしいですか');">
           			</form>
           		</div>
         	</div>
      	</div>
  	</div>   
        
				<!-- トップ戻る -->
   	<div class = "center">
		<a href="index.php">Back To TOP</a>
	</div>
     	
 
 <!-- フッター -->
	<?php include 'include/footer.html';?>
		
 </body>
</html>
