<?php
session_start();
session_regenerate_id(TRUE);
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';


if (!empty($_POST['key'])){
	//金額<-数字チェック
	if (!is_numeric($_POST['amount'] )){
		$error['amount']='int';
	}
	//日付チェック ref  http://okumocchi.jp/php/re.php  /   http://detail.chiebukuro.yahoo.co.jp/qa/question_detail/q1149331471   /   http://www.tryphp.net/2012/03/14/phpsample-preg-date/
	if (!preg_match('/^([1-9][0-9]{3})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/',$_POST['date'])) {
		$error['date']='date';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['transfer'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: update_action.php');
	}
}

$stmt = $pdo->prepare("SELECT transfer.*, a_er.name AS remitter_name, a_ee.name AS remittee_name
 				FROM transfer 
 					JOIN user_accounts AS u_er ON transfer.user_accounts_id_remitter=u_er.id 
 					JOIN accounts AS a_er ON u_er.account_id=a_er.id
					JOIN user_accounts AS u_ee ON transfer.user_accounts_id_remittee=u_ee.id 
 					JOIN accounts AS a_ee ON u_ee.account_id=a_ee.id
				WHERE transfer.id=:id ");
$stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$stmt->execute();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$transfer=$row;
/*
$sql=sprintf("SELECT transfer.*, a_er.name AS remitter_name, a_ee.name AS remittee_name
 				FROM transfer 
 					JOIN user_accounts AS u_er ON transfer.user_accounts_id_remitter=u_er.id 
 					JOIN accounts AS a_er ON u_er.account_id=a_er.id
					JOIN user_accounts AS u_ee ON transfer.user_accounts_id_remittee=u_ee.id 
 					JOIN accounts AS a_ee ON u_ee.account_id=a_ee.id
				WHERE transfer.id=%d", 
			mysql_real_escape_string($_POST['id'])
);
$row=mysql_query($sql) or die(mysql_error());
$transfer=mysql_fetch_assoc($row);
*/
?>

<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>

<body>
		<div id="head">
			<h1>口座移動修正</h1>
		</div>
		
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
   	<div class="container">
   		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<br><h2>修正フォーム   ID：<?php print (h($transfer['id']));?></h2>
              	<form method = "POST" action = "" class = "form-horizontal well">
					<dl>
              		<dt>金額</dt>
                   		<dd>
                   			<input type = "text" name = "amount" class="form-control" value="<?php print (h($transfer['amount']));?>"/>
                   			<?php alert_warning($error['amount']);?>
                     		</dd>
                    	
                    	<dt>送り手</dt>
                   		<dd>
                   			<select  name="user_accounts_id_remitter" class="form-control" >
        	             		<?php $selected=$transfer['user_accounts_id_remitter']?>
        		            		<?php include_once 'include/php/input_user_account_name.php'; ?>
							</select>
						</dd>
						
					<dt>受け手</dt>
                     		<dd>
                     			<select  name="user_accounts_id_remittee" class="form-control" >
                     			<?php $selected=$transfer['user_accounts_id_remittee']?>
                     			<?php include_once 'include/php/input_user_account_name.php'; ?>
							</select>
						</dd>
						
					<dt>移動日</dt>
						<dd>
							<input type = "text" name = "date" class="form-control" value="<?php print (h($transfer['date'])); ?>"/>
							<?php alert_warning($error['date']);?>
						</dd>
						
					<dt>メモ</dt>
						<dd>
							<input type = "text" name = "memo" class="form-control" value="<?php print (h($transfer['memo'])); ?>"/>
						</dd>
					</dl>
					<div class="center">	
        	             	<input type = "hidden" name="id" value="<?php print (h($_POST['id']));?>"> 
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
                           	<input type= "hidden" name="id" value="<?php print (h($_POST['id'])); ?>"> 
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
