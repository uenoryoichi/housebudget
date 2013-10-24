<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 */
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
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
		<h1>口座移動一覧</h1>
	</div>
	
	<!-- insert部ここから -->
    <body>
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>口座移動情報入力フォーム</h2>
                    <div class="control-group">
                        <form method = "POST" action = "insert_action.php" class = "well">
                            <label>金額</label>
                            <input type = "text" name = "amount" class="span3" >
                            <label>送り手</label>
                            	<select  name="user_accounts_id_remitter" id="user_accounts_id_remitter" class="span3" >
								<?php //選択肢にユーザーの口座情報を入れる user_accounts_id?>
                            		<?php require 'function/input_user_account_name.php'; ?>
							</select>
							<label>受け手</label>
                            	<select  name="user_accounts_id_remittee" id="user_accounts_id_remittee" class="span3" >
								<?php //選択肢にユーザーの口座情報を入れる user_accounts_id?>
                            		<?php require  'function/input_user_account_name.php'; ?>
							</select>
							<label>移動日</label>
							<?php $today = date("Y-m-d");?>
                            	<input type = "text" name = "date" class="span3" value=<?php echo $today?>>
                            	<label>memo</label>
                            	<input type = "text" name = "memo" class="span5"  placeholder="">
							<?php  //口座移動情報キー ?>
							<input type = "hidden" name = "key" value="transfer" >
							<label>
							<input type = "submit" value = "送信" class="btn-primary">
                        		</label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
     <!-- insert部ここまで -->
     
	<div class = "center">
		<a href="index.php">Back To TOP</a>
	</div>
     
     <!-- 一覧部ここから -->   
<?php
    $sql =sprintf('SELECT transfer.*, a_er.name AS remitter_name, a_ee.name AS remittee_name
 				FROM transfer 
 					JOIN user_accounts AS u_er ON transfer.user_accounts_id_remitter=u_er.id 
 					JOIN accounts AS a_er ON u_er.account_id=a_er.id
					JOIN user_accounts AS u_ee ON transfer.user_accounts_id_remittee=u_ee.id 
 					JOIN accounts AS a_ee ON u_ee.account_id=a_ee.id
				WHERE transfer.user_id=%d 
 				ORDER BY DATE DESC',
    				$_SESSION['user_id']
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$transfer[] = $row;
	}
?>

	<div class = "center">
		<h2>口座移動情報</h2>
		<table align ="center" >
		<tr>
			<th scope="col">ID</th>
			<th scope="col">金額</th>
			<th scope="col">送り手➡➡➡</th>
			<th scope="col">　　　受け手</th>
			<th scope="col">移動日</th>
			<th scope="col">メモ</th>
			<th scope="col">編集</th>
			<th scope="col">削除</th>
		</tr>

		<?php for ($i = 0; $i < count($transfer); $i++): ?>	
		<tr>
			<td><?php print(htmlspecialchars($transfer[$i]['id'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($transfer[$i]['amount'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($transfer[$i]['remitter_name'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($transfer[$i]['remittee_name'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($transfer[$i]['date'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($transfer[$i]['memo'], ENT_QUOTES));?></td>
			<td>
				<form method = "POST" action = "transfer_update.php" >
                 	<?php  //編集　id送信 ?>
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($transfer[$i]['id'], ENT_QUOTES));?> >
					<input type = "submit" value = "編集" class="btn-primary" >
                </form>
            </td>
            <td>   
                <form method = "POST" action = "delete_action.php" >
                 	<?php  //削除　収入キー送信　id送信 ?>
					<input type = "hidden" name = "key" value="transfer" >
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($transfer[$i]['id'], ENT_QUOTES));?> >
					<input type = "submit" value = "削除" class="btn-primary" onclick="return confirm('削除してよろしいですか');">
                </form>
			</td>
		</tr>
		<?php endfor;?>
	</table>
	</div>

	<div class = "center">
		<a href="index.php">Back To TOP</a>
	</div>

	<!--一覧表示部終わり-->

</body>
</html>

