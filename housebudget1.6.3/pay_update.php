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
	if (!is_numeric($_POST['how_much'] )){
		$error['how_much']='int';
	}
	//日付チェック ref  http://okumocchi.jp/php/re.php  /   http://detail.chiebukuro.yahoo.co.jp/qa/question_detail/q1149331471   /   http://www.tryphp.net/2012/03/14/phpsample-preg-date/
	if (!preg_match('/^([1-9][0-9]{3})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\s(?:(2[0-3])|([0-1][0-9])):([0-5][0-9]):([0-5][0-9])$/',$_POST['date'])) {
		$error['date']='date';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['pay'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: update_action.php');
	}
}

$stmt = $pdo->prepare("SELECT pay.* FROM pay WHERE pay.id=:id");
$stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$stmt->execute();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$date=$row;
/*
$sql=sprintf("SELECT pay.*
 				FROM pay 
				WHERE pay.id=%d",
			mysql_real_escape_string($_POST['id'])
);
$result=mysql_query($sql,$link);
$date=mysql_fetch_assoc($result);
*/

?>

<html lang=ja>
    <?php include 'include/head.html';?>
    
<body>
<?php include 'library/alert.php';?>
	<div id="head">
	　	<h1>支払修正</h1>
	</div>
	
	<?php include 'include/menu.html';?>
	
   	<div class="container">
      	<div class="row">
        		<div class="col-md-offset-3 col-xs-6">
             	<br><h2>修正フォーム   ID：<?php print (h($date['id']));?></h2>
                	<form method = "POST" action = "" class = "form-horizontal well">
					<dl>
                		<dt>金額</dt>
                    		<dd>
                    			<input type = "text" name = "how_much" class="form-control" value="<?php print (h($date['how_much']));?>"/>
                    			<?php alert_warning($error['how_much'])?>
                        	</dd>
                        	
                     <dt>口座名</dt>
						<dd>
							<select  name="user_accounts_id" class="form-control">
							<?php $selected=$date['user_accounts_id']?>
                 	        	<?php require 'include/php/input_user_account_name.php'; ?>
 							</select>
						</dd>
						
					<dt>分類</dt>
                     		<dd>
                     			<select  name="pay_specification_id"class="form-control" >
                     			<?php $selected=$date['pay_specification_id'];?>
							<?php  require_once 'include/php/form_pay_specifications.php';?>
							</select>
                         	</dd>
                         	   
                   	<dt>メモ</dt>
                    		<dd>
                    			<input type = "text" name = "what" class="form-control" value="<?php print (h($date['what']));?>"/>
						</dd>
						
					<dt>日付</dt>
                     		<dd>
                     			<input type = "text" name = "date" class="form-control" value="<?php print (h($date['date']));?>"/>
                     			<?php alert_warning($error['date']);?>
						</dd>
						
                    	</dl>
                     	<div class="center">
                    		<!-- 送信ボタン -->
           				<input type = "hidden" name="id" value="<?php print(h($_POST['id']));?>"> 
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
            				<input type= "hidden" name="pay_id" value="<?php print(h($_POST['id']));?>"> 
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
