<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
?>

<?php 
/*
 * 使っていない口座もサブクエリで抽出しようとしたがサブクエリが複数行を返すのでダメと言われた
 * 	SELECT * FROM accounts a WHERE a.id=(SELECT u.account_id FROM user_accounts u WHERE u.user_id=4)
 * 
 * accountから登録されているすべての口座をとってくる<=classification.name
 * user_accountからチェックを予め付けておく口座の情報を取ってくる<=デザインで修正するまずは上にユーザー、下にすべて
 * 左側に今使ってる口座情報 右に使っていない講座情報を種別ごとあいうえお順に
 * insert_actionにはaccount_idを送る。
 * insertではuser_idとaccount_id入れて口座更新へ飛ばす
 * 
 */
?>

<?php 
//優先：登録口座追加
if (isset($_POST['accounts_name'])&&isset($_POST["accounts_kana"])) {
	$accounts_name=htmlspecialchars($_POST["accounts_name"], ENT_QUOTES);
	$accounts_kana=htmlspecialchars($_POST["accounts_kana"], ENT_QUOTES);
	$account_classification_id=htmlspecialchars($_POST["account_classification_id"], ENT_QUOTES);
	$sql = "INSERT INTO accounts ( name, kana, account_classification_id, created) 
						VALUES (
							'$accounts_name',
							'$accounts_kana',
							'$account_classification_id',
							NOW())"
	;
	mysql_query($sql, $link) or die(mysql_error());
}



//使用中の口座情報
$sql = sprintf('SELECT a.name,a.account_classification_id, u.*  FROM user_accounts u 
		JOIN accounts a ON u.account_id=a.id 
                WHERE u.user_id=%d',
				($_SESSION['user_id'])
);
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$using_accounts[] = $row;
}

//口座情報取得
$sql = sprintf('SELECT *  FROM accounts');
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$accounts[] = $row;
}
for ($i= 0, $count_accounts=count($accounts);  $i < $count_accounts; $i++){
	$using=false;
	for ($j= 0, $count_using_accounts=count($using_accounts);  $j < $count_using_accounts; $j++){ //使用中のものとかぶっていないか
		if ($accounts[$i]['id']==$using_accounts[$j]['account_id']){
			$using=true;
			break;
		};
	};
	if ($using==false) {
		$not_using_accounts[]=$accounts[$i];
	}
	$using=false;
};

//口座種別取得
$sql = sprintf('SELECT *  FROM account_classifications');
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$account_classifications[] = $row;
}
?>


<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/common.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>my家計簿</title>
	</head>

	<!-- 本文　ここから -->
	
	<!-- 見出し ここから　-->
	<div id="head">
		<h1>口座選択</h1>
	</div>
	
	<!-- 一覧表示　ここから　-->
	<?php //使用中の口座一覧?>
	<div class="container">
		<div class="row">
			<div class="span6 offset3">
          		<h2>使用中の口座</h2>
           		<div class="control-group">
           		<?php if ($_POST['can_delete']=="true"):	?>										<?php //削除アクション有効?>
           			<div class="alert">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>口座情報を削除すると関連する収入支出情報も削除されます</strong>
					</div>
					<form action="delete_action.php" method="post">		           		
				<?php else:?>
					<form action="" method="post">												<?php //削除アクション無効?>
				<?php endif;?>
             		<?php for ($i = 0, $count_a_c=count($account_classifications);$i< $count_a_c; $i++):?>
             		<h3><?php echo $account_classifications[$i]['name']?></h3>
             		<table align = "center" >
						<tr>
							<?php if ($_POST['can_delete']=="true"):?><th scope="col">削除</th><?php endif;?>	<?php //削除アクション有効?>
							<th scope="col">口座名</th>
							<th scope="col">金額</th>
						</tr>
						<?php for ($j = 0, $count_using_accounts=count($using_accounts);  $j < $count_using_accounts; $j++): ?>
						<?php if ($using_accounts[$j]['account_classification_id']==$account_classifications[$i]['id']):  //種別が一致しているか?>
						<tr>
							<?php if ($_POST['can_delete']=="true"):?>
							<td class="center"><input type="radio" name="user_accounts_id" value="<?php echo $using_accounts[$j]['id']; ?>"/></td>	<?php //削除アクション有効?>
							<?php endif;?>
							<td><?php print (htmlspecialchars($using_accounts[$j]['name'], ENT_QUOTES));?></td> 
							<td>	<?php print (htmlspecialchars($using_accounts[$j]['balance'], ENT_QUOTES));?></td>
						</tr>
						<?php endif;?>
						<?php endfor;?>
					</table>
					<?php endfor;?>
					<div class="row">
						<div class="offset4">
							<?php if ($_POST['can_delete']=="true"):?>
								<input type="hidden" name="key" value="user_accounts"/>
								<input type="submit" value="削除" class="btn btn-danger"/>
							<?php else:?>
								<input type="hidden" name="can_delete" value="true"/>
								<input type="submit" value="削除を有効にする" class="btn btn-danger"/>
							<?php endif;?>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php //===========================================================?>
	
	<?php //使用してない口座一覧?>
	<div class="container">
		<div class="row">
			<div class="span6 offset3">
          		<h2>登録されている口座から選択</h2>
           		<div class="control-group">
           			<form method= "post" action= "insert_action.php" name ="user"class = "well">
             		<?php for ($i = 0, $count_a_c=count($account_classifications);$i< $count_a_c; $i++):?>
             		<h3><?php echo $account_classifications[$i]['name']?></h3>
             		<table align = "center" >
						<tr >
							<th scope="col">使用選択</th>
							<th scope="col">口座名</th>
						</tr>
						<?php for ($j = 0, $count_not_using_accounts=count($not_using_accounts);  $j < $count_not_using_accounts; $j++): ?>
						<?php if ($not_using_accounts[$j]['account_classification_id']==$account_classifications[$i]['id']):?>
						<tr>
							<td><input type="checkbox" name="account_id[]" value="<?php echo $not_using_accounts[$j]['id']?>" /></td>
							<td><?php print (htmlspecialchars($not_using_accounts[$j]['name'], ENT_QUOTES));?></td>
						</tr>
						<?php endif;?>
						<?php endfor;?>
					</table>
					<div class="row">
						<div class="offset4">
							<input type="hidden" name="key" value="user_accounts_add" />
							<input type="submit" value="選択" class="btn-primary span1 "/>
						</div>
					</div>
					<?php endfor;?>
					</form>
					<h2>上記にない口座を登録</h2>
					<?php //口座追加?>
					<form action="" method="post" name="add_accounts">
						<div class="row"><div class="span4  offset1"><div class="well">
						<select name="account_classification_id" id="account_classification_id" class="span3" >
                            <?php //選択肢口座種別情報を入れる?>
                            <?php require 'function/input_account_classifications.php'; ?>
						</select>
						<input type="hidden" name="add_accounts" valuse="ture">
						<p>名称<input type="text" name="accounts_name" class="span2"/></p>
						<p>かな(全角ひらがな)<input type="text" name="accounts_kana" class="span2"/></p>
						<input type="submit" value="新規登録" class="btn-primary"/>
						</div></div></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="center">
		<a href="index.php">Back To TOP</a>
	</div>

	<!--一覧表示部終わり-->
</body>
</html>

