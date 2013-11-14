<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';

mb_language("japanese");
mb_internal_encoding("UTF-8");
 
if (!empty($_POST['email'])) {
	$to = $_POST['email'];
	$subject = $_POST['subject'];
	$body = $_POST['message'];
	$from = mb_encode_mimeheader(mb_convert_encoding("my家計簿 自動送信","JIS","UTF-8"))."<support@lost-waldo.jp>";
	
	$success = mb_send_mail($to,$subject,$body,"From:".$from);
}
?>
<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>収入一覧</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
<div id="content">
	<div class = "center">
		<br>
		<br>
		<h3>
			<?php if ($success) :?>
				<?php echo h($to);?>へ送信しました
			<?php else: ?>
				送信に失敗しました
			<?php endif?>
		</h3>
	</div>
</div>
<!-- フッター -->
<?php include 'include/footer.html';?>

			
</body>
</html>
