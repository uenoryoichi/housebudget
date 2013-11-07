<?php
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
$recordSet=mysql_query($sql) or die(mysql_error());
$date=mysql_fetch_assoc($recordSet);
?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダー -->
    <?php include 'include/head.html';?>

<body>
    
    	<!-- 見出し -->
	<div id="head">
		<h1>収入修正</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
    
   	<div class="container">
   		<div class="row">
			<div class="col-md-offset-3 col-md-6">
                 <br><h2>修正フォーム   ID：<?php print (htmlspecialchars($date['id'],ENT_QUOTES));?></h2>
               	<form method = "POST" action = "update_action.php" class = "form-horizontal well">
               		<dl>
	                	<dt>金額</dt>
    		            		<dd>
    		            			<input type = "text" name = "amount" class="form-control" value="<?php print (htmlspecialchars($date['amount'],ENT_QUOTES));?>"/>
						</dd>
						                       
        	          	<dt>内容</dt>
           	        		<dd>
           	        			<input type = "text" name = "content" class="form-control" value="<?php print (htmlspecialchars($date['content'],ENT_QUOTES));?>"/>
						</dd>
						
					<dt>日付</dt>
                			<dd>
                				<input type = "text" name = "date" class="form-control" value="<?php print (htmlspecialchars($date['date'],ENT_QUOTES));?>"/>
						</dd>
						
					<dt>口座名</dt>
						<dd>
						<select  name="user_accounts_id" class="form-control" >
             	    			<?php //選択肢にユーザーの口座情報を入れる?>
                   			<?php $selected=$date['user_accounts_id']?>
                		    		<?php require 'function/input_user_account_name.php'; ?>
						</select>
						</dd>
					</dl>
					<div class="center">	
						<?php //ID?>
    	                 	<input type = "hidden" name="income_id" value="<?php print(htmlspecialchars($id));?>"> 
	    	                	<?php //収入情報キー?>	
						<input type = "hidden" name = "key" value="income" >
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
                			<input type= "hidden" name="income_id" value="<?php print(htmlspecialchars($id, ENT_QUOTES));?>"> 
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