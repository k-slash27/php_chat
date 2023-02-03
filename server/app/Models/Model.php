<?php
declare(strict_types=1);

namespace App\Models;

require_once __PROJECT_ROOT__ . "/vendor/autoload.php";

/*
 * Databaseクラス
 */
class Model
{

    private $pdo;

    /*
    * コンストラクタ
    * @var host
    * @var user
    * @var pass
    * @var db
    */
    public function __construct()
    {
        $host = __DB_HOST__;
        $user = __DB_USER__;
        $pass = __DB_PASS__;
        $db = __DB_USE__;

        $dsn = "mysql:dbname={$db};host={$host}";

        try {
            $this->pdo = new \PDO ($dsn, $user, $pass, array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        } catch(PDOException $e) {
            echo 'Connection failed:'.$e->getMessage();
            exit;
        }
    }

    /*
    * フェッチ処理
    * @param $sql
    */
    function fetch($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch(PDOException $e) {
            echo 'Connection failed:'.$e->getMessage();
            return false;
        }
    }

    /*
    * 実行処理
    * @param $sql
    */
    function execute($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
            $stmt->execute();
            $data = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $data;
        } catch(PDOException $e) {
            $this->pdo->rollBack();
            echo 'Connection failed:'.$e->getMessage();
            return false;
        }
    }

    /*
    * 更新処理
    * @param $sql
    */
    function update($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
            $rtn = $stmt->execute();
            $this->pdo->commit();
            return $rtn;
        } catch(PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
?>
