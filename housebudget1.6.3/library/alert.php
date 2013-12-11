<?php 
function alert_warning($error) {
	if (!empty($error)){
		if ($error=='empty') {
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">* 必須項目です。入力してください</p>');
			print ('</div>');
		};
		if ($error=='int') {
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">* 半角数字を入力してください</p>');
			print ('</div>');
		};
		if ($error=='date'){
			$date_format=date('Y-m-d H:i:s');
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">* '.$date_format.' のフォーマットで入力してください</p>');
			print ('</div>');
		};
		if($error=='no_email'){
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">* メールアドレスの形式が不正です</p>');
			print ('</div>');
		};
		if ($error=='duplicate') {
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">* すでに登録されています。</p>');
			print ('</div>');
		};
		if ($error=='no_kana') {
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">* 全角ひらがなで入力してください</p>');
			print ('</div>');
		}
		if ($error=='timeout') {
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">フォームの有効期限切れです</p>');
			print ('</div>');
		}
		if ($error=='token_disagreement') {
			print ('<div class="alert alert-warning alert-dismissable">');
			print ('<p class="error">無効なフォームです。</p>');
			print ('</div>');
		}
	};
}

function alert_success($success){						
 	if ($success=='insert') {
 		print ('<div class="alert alert-info alert-dismissable">');
		print ('<button type = "button" class="close" data-dismiss="success" aria-hidden="true" >&times;</button>');
		print ('<strong >追加しました。</strong>');
		print ('</div>');
 	};

	if ($success=='delete') {
		print ('<div class="alert alert-danger alert-dismissable">');
		print ('<button type = "button" class="close" data-dismiss="success" aria-hidden="true" >&times;</button>');
		print ('<strong >削除しました。</strong>');
		print ('</div>');
	};

	if ($success=='update') {
		print ('<div class="alert alert-success alert-dismissable">');
		print ('<button type = "button" class="close" data-dismiss="success" aria-hidden="true" >&times;</button>');
		print ('<strong >更新しました。</strong>');
		print ('</div>');
	};
}