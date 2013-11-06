<?php

/*
 * バージョン管理
 * 1.5.3
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
$sql=sprintf("SELECT transfer.*, a_er.name AS remitter_name, a_ee.name AS remittee_name
 				FROM transfer 
 					JOIN user_accounts AS u_er ON transfer.user_accounts_id_remitter=u_er.id 
 					JOIN accounts AS a_er ON u_er.account_id=a_er.id
					JOIN user_accounts AS u_ee ON transfer.user_accounts_id_remittee=u_ee.id 
 					JOIN accounts AS a_ee ON u_ee.account_id=a_ee.id
				WHERE transfer.id=%d", 
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
			<h1>口座移動修正</h1>
		</div>
		
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
   	<div class="container">
   		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<br><h2>修正フォーム   ID：<?php print (htmlspecialchars($date['id'],ENT_QUOTES));?></h2>
              	<form method = "POST" action = "update_action.php" class = "form-horizontal well">
                    	<!-- 修正記入 -->
                    	<label>金額</label>
                   	<input type = "text" name = "amount" class="form-control" value="<?php print (htmlspecialchars($date['amount'],ENT_QUOTES));?>"/>
                     
                    	<label>送り手</label>
                   	<select  name="user_accounts_id_remitter" class="form-control" >
                     		<?php //選択肢にユーザーの口座情報を入れる?>
                     		<?php $selected=$date['user_accounts_id_remitter']?>
                    		<?php require 'function/input_user_account_name.php'; ?>
					</select>
		
					<label>受け手</label>
                     	<select  name="user_accounts_id_remittee" class="form-control" >
                     		<?php //選択肢にユーザーの口座情報を入れる?>
                     		<?php $selected=$date['user_accounts_id_remittee']?>
                     		<?php require 'function/input_user_account_name.php'; ?>
					</select>
	
					<label>移動日</label>
					<input type = "text" name = "date" class="form-control" value="<?php print (htmlspecialchars($date['date'],ENT_QUOTES));?>"/>
		
					<label>メモ</label>
					<input type = "text" name = "memo" class="form-control" value="<?php print (htmlspecialchars($date['memo'],ENT_QUOTES));?>"/>
	
					<div class="center">	
						<!-- 送信ボタン -->
						<?php // ID ?>
        	             	<input type = "hidden" name="transfer_id" value="<?php print(htmlspecialchars($id));?>"> 
						<?php //口座移動情報キー?>
						<input type = "hidden" name = "key" value="transfer" >
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
                           	<input type= "hidden" name="id" value="<?php print(htmlspecialchars($id, ENT_QUOTES));?>"> 
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
