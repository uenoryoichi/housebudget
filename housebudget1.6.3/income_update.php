<?php
session_start();
//データベースへの接続 housebudget
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
	if (!preg_match('/^([1-9][0-9]{3})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\s(?:(2[0-3])|([0-1][0-9])):([0-5][0-9]):([0-5][0-9])$/',$_POST['date'])) {
		$error['date']='date';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['income'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: update_action.php');
	}
}
$id=$_POST['id'];
$sql=sprintf('SELECT income.*, accounts.name AS accounts_name, income_specifications.name AS income_specification_name
 				FROM income 
 					JOIN user_accounts ON income.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id 
					JOIN income_specifications ON income.income_specification_id=income_specifications.id
 				WHERE income.id=%d',
				mysql_real_escape_string($id),
				mysql_real_escape_string($_SESSION['user_id'])
);
$recordSet=mysql_query($sql) or die(mysql_error());
$income=mysql_fetch_assoc($recordSet);
?>

<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダー -->
    <?php include 'include/head.html';?>

<body>
    
	<div id="head">
		<h1>収入修正</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
    
   	<div class="container">
   		<div class="row">
			<div class="col-md-offset-3 col-md-6">
                 <br><h2>修正フォーム</h2>
               	<form method = "POST" action = "" class = "form-horizontal well">
               		<dl>
	                	<dt>金額</dt>
    		            		<dd>
    		            			<input type = "text" name = "amount" class="form-control" value="<?php print (h($income['amount']));?>"/>
    		            			<?php alert_warning($error['amount']); ?>
						</dd>
						                       
        	          	<dt>口座名</dt>
						<dd>
						<select  name="user_accounts_id" class="form-control" >
                   			<?php $selected=$income['user_accounts_id']?>
                		    		<?php require 'include/php/input_user_account_name.php'; ?>
						</select>
						</dd>
					
					<dt>分類</dt>
                     		<dd>
                     			<select  name="income_specification_id"class="form-control" >
                     			<?php $selected=$income['income_specification_id'];?>
							<?php  require_once 'include/php/form_income_specifications.php';?>
							</select>
                         	</dd>    	
                      	
					<dt>メモ</dt>
           	        		<dd>
           	        			<input type = "text" name = "content" class="form-control" value="<?php print (h($income['content']));?>"/>
						</dd>
						
					<dt>日付</dt>
                			<dd>
                				<input type = "text" name = "date" class="form-control" value="<?php print (h($income['date']));?>"/>
                				<?php alert_warning($error['date']); ?>
						</dd>
						
					
					</dl>
					<div class="center">	
    	                 	<input type = "hidden" name="id" value="<?php print(h($id));?>"> 
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
                			<input type= "hidden" name="income_id" value="<?php print(h($id));?>"> 
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