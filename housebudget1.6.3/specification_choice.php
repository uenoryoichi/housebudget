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


//削除ボタン時の動作
if ($_POST['key']=="not_use"){
	//入力不足チェック
	if (empty($_POST['not_use_pay_specification_id'])){
		$error['not_use_pay_specification_id']='empty';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$stmt = $pdo->prepare('UPDATE pay_specifications 
				SET uses=1 
				WHERE id=:id AND user_id=:user_id');
		$stmt->bindValue(':id', $_POST['not_use_pay_specification_id'], PDO::PARAM_INT);
		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		/*
		$sql=sprintf('UPDATE pay_specifications SET uses=1 
			WHERE id=%d AND user_id=%d',
		mysql_real_escape_string($_POST['not_use_pay_specification_id']),
		mysql_real_escape_string($_SESSION['user_id'])
		);
		mysql_query($sql) or die(mysql_error());
		*/
		$_POST=NULL;
		$success='delete';
	}
}



//分類追加ボタン時の動作 支払
if ($_POST['key']=="add_pay_specification") {
	if (empty($_POST['specification_name'])) {
		$error['specification_name']='empty';
	}
	
	if (empty($error)){
		$stmt = $pdo->prepare('INSERT INTO pay_specifications SET name=:name, user_id=:user_id, created=NOW(), uses=0');
		$stmt->bindValue(':name', $_POST["specification_name"], PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		/*
		$sql = sprintf('INSERT INTO pay_specifications SET name="%s", user_id=%d, created=NOW(), uses=0', 
							mysql_real_escape_string($_POST["specification_name"]),
							mysql_real_escape_string($_SESSION['user_id'])
		);
		mysql_query($sql, $link) or die(mysql_error());
		*/
		$add_specification_name=$_POST['specification_name'];
		$_POST=NULL;
		$success="pay";
	}
}

//分類追加ボタン時の動作 収入
if ($_POST['key']=="add_income_specification") {
	if (empty($_POST['specification_name'])) {
		$error['specification_name']='empty';
	}

	if (empty($error)){
		$stmt = $pdo->prepare('INSERT INTO income_specifications SET name=:name, user_id=:user_id, created=NOW(), uses=0');
		$stmt->bindValue(':name', $_POST["specification_name"], PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		/*
		$sql = sprintf('INSERT INTO income_specifications SET name="%s", user_id=%d, created=NOW() ,uses=0',
				mysql_real_escape_string($_POST["specification_name"]),
				mysql_real_escape_string($_SESSION['user_id'])
		);
		mysql_query($sql, $link) or die(mysql_error());
		*/
	$add_specification_name=$_POST['specification_name'];
	$_POST=NULL;
	$success="income";
	}
}


//表示される分類項目を取得(デフォルト＋ユーザー)
$stmt = $pdo->prepare('SELECT *  FROM pay_specifications 
				WHERE user_id=0 OR user_id=:user_id AND uses=0
				ORDER BY user_id ASC');
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$pay_specifications[] = $row;
}

$stmt = $pdo->prepare('SELECT *  FROM income_specifications
				WHERE user_id=0 OR user_id=:user_id AND uses=0
				ORDER BY user_id ASC');
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$income_specifications[] = $row;
}
/*
$sql = sprintf('SELECT *  FROM pay_specifications 
				WHERE user_id=0 OR user_id=%d AND uses=0
				ORDER BY user_id ASC',
				mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$pay_specifications[] = $row;
}

$sql = sprintf('SELECT *  FROM income_specifications
				WHERE user_id=0 OR user_id=%d AND uses=0
				ORDER BY user_id ASC',
		mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$income_specifications[] = $row;
}
*/

if (!empty($_SESSION['success'])) {
	$success=$_SESSION['success'];
	$_SESSION['success']=NULL;
}



?>

<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>分類項目選択</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
 
	<div class="container">
		<div class="row"> 		
			<?php if ($success=='income' || $success=='pay'):	?>									
    	    			<div class="alert alert-success alert-dismissable">
					<button type = "button" class="close" data-dismiss="success" aria-hidden="true" >&times;</button>
					<strong ><?php echo h($add_specification_name);?>を追加しました。</strong>
				</div>
			<?php endif;?>
			<?php alert_success($success)?>
			<div class="col-md-offset-1 col-md-4">
				<div class = "center">
					<br><br><h2>表示される支払い分類項目一覧</h2>
						<form action="" method="post" class= "form-horizontal">
             			<table class="table table-hover table-bordered table-condensed">
							<thead>
								<tr>
									<th scope="col" class="center">削除</th>
									<th scope="col">分類名</th>
								</tr>
							</thead>
							
							<?php for ($j = 0, $count_p_s=count($pay_specifications);  $j < $count_p_s; $j++): ?>
							<tbody>
								<tr>
									<td class="center">
										<?php if ($pay_specifications[$j]['user_id']!=0):?>   <?php //ユーザー独自定義の分類の場合削除ボタンを追加?>
											<form method="post" action="" >
												<input type="hidden" name="key" value="not_use">	
												<input type="hidden" name="not_use_pay_specification_id" value=<?php echo h($pay_specifications[$j]['id']); ?>	>	
												<input type="submit" value="削除" class="btn btn-danger btn-xs" >
											</form>
										<?php endif?>
									</td>
									<td><?php print (h($pay_specifications[$j]['name']));?></td> 	
								</tr>
							</tbody>
							<?php endfor;?>
						</table>
				</div>
			</div>
		
			<div class="col-md-offset-3 col-md-4">
				<div class = "center">				
					<br><br><h2>表示される収入分類項目一覧</h2>
						<table class="table table-hover table-bordered table-condensed">
							<thead>
								<tr>
									<th scope="col" class="center">削除</th>
									<th scope="col">分類名</th>
								</tr>
							</thead>
							
							<?php for ($j = 0, $count_i_s=count($income_specifications);  $j < $count_i_s; $j++): ?>
							<tbody>
								<tr>
									<td class="center">
										<?php if ($income_specifications[$j]['user_id']!=0):?>
											<form method="post" action="" >
												<input type="hidden" name="key" value="not_use">	
												<input type="hidden" name="not_use_income_specification_id" value=<?php echo h($income_specifications[$j]['id']); ?>	>	
												<input type="submit" value="削除" class="btn btn-danger btn-xs" >
											</form>
										<?php endif?>
									</td>
									<td><?php print (h($income_specifications[$j]['name']));?></td> 	
								</tr>
							</tbody>
							<?php endfor;?>
						</table>
				</div>
			</div>
		</div>
	</div>
	
	<?php //===========================================================?>
	<?php //口座追加?>
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<div class = "center">
					<br><br><h2>ユーザー独自の分類を登録</h2>
					<form action="" method="post" class = "form-horizontal well">
						<label>分類</label>
							<select name="key"  class="form-control" >
                          		<option value="add_pay_specification">支払</option>
                          		<option value="add_income_specification">収入</option>
                          	</select>
						
						<label>名称</label>
						<input type="text" name="specification_name" class="form-control" value="<?php echo (h($rewrite['specification_name'])); ?>"/>
						<?php alert_warning($error['specification_name']);?>
						<input type="submit" value="追加" class="btn btn-success"/>
					</form>
				</div>
			</div>
		</div>
	</div>
				
	<div class="center">
		<a href="index.php">Back To TOP</a>
	</div>
	<!-- フッター -->
	<?php include 'include/footer.html';?>
	
</body>
</html>
