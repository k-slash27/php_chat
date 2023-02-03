<?php
declare(strict_types=1);

namespace App\Controllers;

require_once __PROJECT_ROOT__ . "/vendor/autoload.php";

use SassCompiler;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

class Controller
{
    protected function __construct() {

    }

    public function Logging($message, string $file_name = 'app.log') {

    }

    public function view(string $template, array $param): string {
        // 開発環境の場合、SASSコンパイル
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            SassCompiler::run("/var/www/html/scss/", "/var/www/html/static/css/", "style.scss");
        }

        // Viewへのレンダリング
        $loader = new FilesystemLoader(__VIEW_DIR__);
        $twig = new Environment($loader);
        return $twig->render($template . ".html", $param);
    }
}