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

$id=$_POST['id'];
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
    
<body>
	<div id="head">
	　	<h1>支払修正</h1>
	</div>
	
	<!-- メニューバー -->
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
                    			<?php if ($error['how_much']=='int'):?>
								<div class="alert alert-warning">
									<p class="error">* 数字（半角）を入力してください</p>
                    				</div>	
                    			<?php endif; ?>
                        	</dd>
                        	
                     	<dt>内容</dt>
                    		<dd>
                    			<input type = "text" name = "what" class="form-control" value="<?php print (h($date['what']));?>"/>
						</dd>
						
					<dt>日付</dt>
                     		<dd>
                     			<input type = "text" name = "date" class="form-control" value="<?php print (h($date['date']));?>"/>
                     			<?php if ($error['date']=='date'):?>
								<div class="alert alert-warning">
									<p class="error">* <?php echo date('Y-m-d H:i:s');?> のフォーマットで入力してください</p>
                    				</div>	
                    			<?php endif; ?>
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
                     			<input type = "text" name = "type" class="form-control" value="<?php print (h($date['type']));?>"/>
                       	</dd>
                    	</dl>
                     	<div class="center">
                    		<!-- 送信ボタン -->
           				<input type = "hidden" name="id" value="<?php print(h($id));?>"> 
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
            				<input type= "hidden" name="pay_id" value="<?php print(h($id));?>"> 
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
