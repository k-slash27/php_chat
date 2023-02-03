# 機能

## 投稿機能

## 削除機能
- 削除ボタンをクリックすると、ポップアップを表示
- 投稿時の削除キーをポップアップのtextboxに入力
- DBの削除キーと同一であれば投稿削除

## 画像アップロード
- 投稿時に画像をアップロード可能
- png, jpg, gifのみ許可

## いいねボタン
- 押すとDBのlike_countをインクリメント
- 投稿履歴のいいねボタン横の数字を表示


# 使用技術
- Twig（テンプレートエンジン）
- PHP-SASS（SASSビルダ。Controller.phpのview()にて、Viewレンダリング時にビルド実行。）
- autoloader（MVC,Configファイルのrequire簡略化・その他scss,Twigビルド用）