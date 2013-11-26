<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';



//削除ボタン
if ($_POST['key']=="not_use"){
	//入力不足チェック
	if (empty($_POST['not_use_pay_specification_id'])){
		$error['not_use_pay_specification_id']='empty';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$sql=sprintf('UPDATE pay_specifications SET uses=1 
			WHERE id=%d AND user_id=%d',
		mysql_real_escape_string($_POST['not_use_pay_specification_id']),
		mysql_real_escape_string($_SESSION['user_id'])
	);
	mysql_query($sql) or die(mysql_error());
	unset($_POST);
	}
}


//分類追加ボタン 支払
if ($_POST['key']=="add_pay_specification") {
	if (!isset($_POST['specification_name'])) {
		$error['specification_name']='empty';
	}
	
	if (empty($error)){
		$sql = sprintf('INSERT INTO pay_specifications SET name="%s", user_id=%d, created=NOW(), uses=0', 
							mysql_real_escape_string($_POST["specification_name"]),
							mysql_real_escape_string($_SESSION['user_id'])
	);
	mysql_query($sql, $link) or die(mysql_error());
	}
	$add_specification_name=$_POST['specification_name'];
	unset($_POST);
	$success="pay";
}

//分類追加ボタン 収入
if ($_POST['key']=="add_income_specification") {
	if (!isset($_POST['specification_name'])) {
		$error['specification_name']='empty';
	}

	if (empty($error)){
		$sql = sprintf('INSERT INTO income_specifications SET name="%s", user_id=%d, created=NOW() ,uses=0',
				mysql_real_escape_string($_POST["specification_name"]),
				mysql_real_escape_string($_SESSION['user_id'])
		);
		mysql_query($sql, $link) or die(mysql_error());
	}
	$add_specification_name=$_POST['specification_name'];
	unset($_POST);
	$success="income";
}


//表示される分類項目を取得(デフォルト＋ユーザー)
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
?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>my家計簿</h1>
		<h1>分類項目選択</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
 
	<div class="container">
		<div class="row"> 		
			<?php if (isset($success)):	?>									
    	    			<div class="alert alert-success alert-dismissable">
					<button type = "button" class="close" data-dismiss="success" aria-hidden="true" >&times;</button>
					<strong ><?php echo $add_specification_name;?>を追加しました。</strong>
				</div>
			<?php endif;?>
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
										<?php if ($pay_specifications[$j]['user_id']!=0):?>
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
							
							<?php for ($j = 0, $count_i_s=count($income_specifications);  $j < $count_i_s; $j++): 							?>
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
						<?php if ($error["specification_name"]=="empty"):?>
							<div class="alert alert-warning">
								<p class="error">* 入力してください</p>
                				</div>	
                    		<?php endif; ?>
						<input type="text" name="specification_name" class="form-control" value="<?php echo (h($rewrite['specification_name'])); ?>"/>
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