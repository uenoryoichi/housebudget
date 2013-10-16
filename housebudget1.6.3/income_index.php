<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * メモ
 * マスタ利用時修正必要
 * 
 * 
 */

session_start();

//データベースへの接続 housebudget
require 'connect_housebudget.php';


//ログインチェック
require 'login_check.php';


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
		<h1>収入一覧</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	<!-- insert部ここから -->
    <body>
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>収入情報入力フォーム</h2>
                    <div class="control-group">
                        <form method = "POST" action = "insert_action.php" class = "well">
                            <label>金額</label>
                            <input type = "text" name = "amount" class="span3" >
                            <label>内容</label>
                            <input type = "text" name = "content" class="span3" placeholder= "">
							<label>日付</label>
							<?php $today = date("Y-m-d");?>
                            <input type = "text" name = "date" class="span3" value=<?php echo $today?>>
                            <label>口座名</label>
                            <select  name="account" id="account" class="span3" >
                            <?php 
								$kouza_array = array("現金","JCB","ゆうちょ銀行","住信SBIネット銀行","三井住友銀行","GMOクリック証券","SBI証券","松井証券","マネックス証券","大和証券","三菱UFJ銀行");
								for ($i=0; $i<count($kouza_array); $i++){
									print('<option value="'.$kouza_array[$i].'">'.$kouza_array[$i].'</option>');
								}
							?>
							</select>
                            <!-- <input type = "text" name = "account"　class="span3" placeholder="">-->
							<?php  //収入情報キー ?>
							<input type = "hidden" name = "key" value="income" >
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
    $sql = 'SELECT * FROM income ORDER BY ID DESC';
	$result = mysql_query($sql, $link);

	while ($row = mysql_fetch_assoc($result)) {
		$pay[] = $row;
	}
?>
	<div class = "center">
	<h2>収入情報</h2>
	<table align = "center" >
		<tr>
			<th scope="col">ID</th>
			<th scope="col">金額</th>
			<th scope="col">内容</th>
			<th scope="col">日付</th>
			<th scope="col">口座名</th>
			<th scope="col">編集</th>
			<th scope="col">削除</th>
		</tr>

		<?php for ($i = 0; $i < count($pay); $i++): ?>
	
		<tr>
			<td><?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['amount'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['content'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['date'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($pay[$i]['account'], ENT_QUOTES));?></td>
			<td>
				<form method = "POST" action = "income_update.php" >
                 	<?php  //編集　id送信 ?>
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?> >
					<input type = "submit" value = "編集" class="btn-primary" >
                </form>
            </td>
            <td>   
                <form method = "POST" action = "delete_action.php" >
                 	<?php  //削除　収入キー送信　id送信 ?>
					<input type = "hidden" name = "key" value="income" >
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

