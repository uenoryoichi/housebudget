<?php

/*
 * バージョン管理
 * 1.6.2
 * 
 * マスタ利用時変更必要
 * 
 */

session_start();

//データベースへの接続 housebudget
require 'connect_housebudget.php';


//ログインチェック
require 'login_check.php';



//$recordSet=mysql_query('SELECT a_m.name, p.* FROM account_user_master a_u_m, account_master a_m, pay p, WHERE m.id=i.maker_id ORDER BY id DESC');
/*
 * user_idをページ内に保存
 * account_user_masterを参照してuser_idと一致していたもののaccount_idとaccount_master内のidを参照
 * 一致しているもののnameを出力
 * 
 */



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
		<h1>支出一覧</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	<!-- insert部ここから -->
    <body>
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>支出情報入力フォーム</h2>
                    <div class="control-group">
                        <form method = "POST" action = "insert_action.php" class = "well">
                            <label>金額</label>
                            <input type = "text" name = "how_much" class="span3" >
                            <label>内容</label>
                            <input type = "text" name = "what" class="span5" placeholder= "">
							<label>日付</label>
							<?php $today = date("Y-m-d");?>
                            <input type = "text" name = "date" class="span3" value=<?php echo $today?>>
                            <label>支払い</label>
                       		<select  name="how" id="how" class="span3" >
							<?php //選択肢にユーザーの口座情報を入れる?>
                            <?php require 'input_user_account_name.php'; ?>
							</select>
                         	<label>分類</label>
                            <select  name="type" id="type" class="span3" >
							<?php 
								$bunrui_array = array("交通費","食費","消耗品","交際費","HUCC","研究室","その他");
								for ($i=0; $i<count($bunrui_array); $i++){
									print('<option value="'.$bunrui_array[$i].'">'.$bunrui_array[$i].'</option>');
								}
							?>
							</select>
                         	<?php  //支出情報キー ?>
							<input type = "hidden" name = "key" value="pay" >
							<input type = "submit" value = "送信" class="btn-primary">
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
    $sql = 'SELECT * FROM pay ORDER BY ID DESC';
	$result = mysql_query($sql, $link);

	while ($row = mysql_fetch_assoc($result)) {
		$pay[] = $row;
	}
?>
	<div class = "center">
	<h2>支出情報</h2>
	<table align = "center" >
		<tr>
			<th scope="col">ID</th>
			<th scope="col">値段</th>
			<th scope="col">支払い内容</th>
			<th scope="col">日付</th>
			<th scope="col">現金orカード</th>
			<th scope="col">種別</th>
			<th scope="col">編集</th>
			<th scope="col">削除</th>
			</tr>

		<?php for ($i = 0; $i < count($pay); $i++): ?>
	
		<tr>
			<td><?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['how_much'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['what'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['date'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['how'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['type'], ENT_QUOTES));?></td>
			<td>
				<form method = "POST" action = "pay_update.php" >
                 	<?php  //編集　id送信 ?>
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?> >
					<input type = "submit" value = "編集" class="btn-primary" >
                </form>
            </td>
            <td>   
                <form method = "POST" action = "delete_action.php" >
                 	<?php  //削除　収入キー送信　id送信 ?>
					<input type = "hidden" name = "key" value="pay" >
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?> >
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

