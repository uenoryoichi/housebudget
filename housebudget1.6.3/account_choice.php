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
 * 
 * 
 */
?>
<?php 
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
	$using=1;
	for ($j= 0, $count_using_accounts=count($using_accounts);  $j < $count_using_accounts; $j++){ //使用中のものとかぶっていないか
		if ($accounts[$i]['id']==$using_accounts[$j]['account_id']){
			$using=2;
			break;
		};
	};
	if ($using==1) {
		$not_using_accounts[]=$accounts[$i];
	}
	$using=1;
};
var_dump($not_using_accounts);
var_dump($count_using_accounts);
var_dump($count_accounts);



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
             		<?php for ($i = 0, $count_a_c=count($account_classifications);$i< $count_a_c; $i++):?>
             		<h3><?php echo $account_classifications[$i]['name']?></h3>
             		<table align = "center" >
						<tr>
							<th scope="col">口座名</th>
							<th scope="col">金額</th>
						</tr>
						<?php for ($j = 0, $count_accounts=count($accounts);  $j < $count_accounts; $j++): ?>
						
						<?php if ($accounts[$j]['account_classification_id']==$account_classifications[$i]['id']):  //種別が一致しているか?>
						
						<tr>
							<td><?php print (htmlspecialchars($using_accounts[$j]['name'], ENT_QUOTES));?></td>
							<td>	<?php print (htmlspecialchars($using_accounts[$j]['balance'], ENT_QUOTES));?></td>
						</tr>
						
						<?php endif;?>
						<?php endfor;?>
					</table>
					<?php endfor;?>
				</div>
			</div>
		</div>
	</div>
	
	<?php //使用してない口座一覧?>
	<div class="container">
		<div class="row">
			<div class="span6 offset3">
          		<h2>登録されている口座から選択</h2>
           		<div class="control-group">
           			<form method= "post" action= "insert_action.php" class = "well">
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
					<div class="row"><div class="span2  offset3"><div class="well"><div class="center">
						<input type="hidden" name="key" value="user_accounts_add" />
						<input type="submit" value="追加" class="btn-primary span1 "/>	
					</div></div></div></div>
					<?php endfor;?>
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

