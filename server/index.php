<?php
if (empty($_SERVER['REQUEST_URI'])) {
  exit;
}

require_once __DIR__ . "/vendor/autoload.php";

use Configure\Configure;
use Configure\Validate;

$c = new Configure();
$v = new Validate();

// URLをスラッシュで分解
$array_parse_uri = explode('/', $_SERVER['REQUEST_URI']);

// PHPファイル名抽出
$last_uri = end($array_parse_uri);
$last_uri = substr($last_uri, 0, strcspn($last_uri,'?'));
$uris = explode('_', $last_uri);
$call = reset($uris);
$call = ucfirst(strtr(ucwords(strtr($call, ['_' => ' '])), [' ' => ''])) . "Controller";


// PHPファイル名がapp/controller/配下の場合
if (file_exists(__CONTROLLER_DIR__ . "/" . $call . ".php")) {

    // コントローラーをインクルードしてインスタンス化
    include(__CONTROLLER_DIR__ . "/" . $call . ".php");
    $class = 'App\Controllers\\' . $call;
    $obj = new $class();

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        // GETならindexメソッドを呼び出す
        $response = $obj->index();
    } else {
        // POSTデータバリデーション 
        $errors = $v->main($_POST);
        if ($errors) {
            header("HTTP/1.1 400 " . json_encode($errors));
            exit;
        }
        // POST時のメソッド名定義（例：post/postAbc）
        $method = "post" . ucfirst( end($uris) );
        if ($method == "postIndex") {
            $method = "post";
        }
        // POSTならpostメソッドを呼び出す
        $response = $obj->$method();
    }

    // コントローラーからのレスポンスを出力
    echo $response;
    exit;

} else {
    // ファイルがなければ404エラー
    header("HTTP/1.0 404 Not Found");
    exit;
}