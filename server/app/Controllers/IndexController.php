<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Chat;

class IndexController extends Controller
{
    public function __construct() {
    }


    public function index() {
        $chat = new Chat();
        $result = $chat->fetchAll();
        return $this->view('index', ['data' => $result]);
    }


    public function post() {
        if (!isset($_POST['name']) || !isset($_POST['message']) || !isset($_POST['passcode']))
            return http_response_code( 400 );
        
        $data = [
            'name' => $_POST['name'],
            'message' => $_POST['message'],
            'passcode' => $_POST['passcode']
        ];

        $chat = new Chat();
        $result = $chat->insert($data);

        if ($result === false)
            return http_response_code( 505 );

        return json_encode($result);
    }

    
    public function postDelete() {
        if (!isset($_POST['id']) || !isset($_POST['passcode']))
            return http_response_code( 400 );

        $data = [
            'id' => $_POST['id'],
            'passcode' => $_POST['passcode']
        ];

        $chat = new Chat();
        $result = $chat->delete($data);

        if ($result === false) {
            $errors = [
                'passcode' => ['削除に失敗しました。削除キーが正しいか確認してください。']
            ];
            header("HTTP/1.1 400 " . json_encode($errors));
            exit;
        }

        return json_encode($result);
    }
}