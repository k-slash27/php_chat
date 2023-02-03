<?php
declare(strict_types=1);

namespace Configure;


class Configure
{    
    // 環境変数
    private $env = [
        '__ENV__' => 'local', // [local, test, prod] の中から選択
        '__PROJECT_ROOT__' => '/var/www/html/',
        '__CONTROLLER_DIR__' => '/var/www/html/app/Controllers',
        '__MODEL_DIR__' => '/var/www/html/app/Models',
        '__VIEW_DIR__' => '/var/www/html/app/Views',
    ];

    // DB環境変数
    private $db = [
        // 本番DB (※適宜変更)
        'prod' => [
            'host' => 'localhost',
            'user' => 'admin',
            'pass' => '5U1019M0',
            'use' => 'masam'
        ],
        // 検証DB (※適宜変更)
        'test' => [
            'host' => 'localhost',
            'user' => 'admin',
            'pass' => 'admin',
            'use' => 'masam'
        ],
        // ローカルDB
        'local' => [
            'host' => 'mysql5.7',
            'user' => 'admin',
            'pass' => 'admin',
            'use' => 'chat',
        ]
    ];

    public function __construct() {
        // 環境定義
        foreach ($this->env as $key => $val) {
            define($key, $val);
        }

        // DB環境定義
        foreach ($this->db[__ENV__] as $key => $val) {
            define('__DB_'.strtoupper($key).'__', $val);
        }
    }
}