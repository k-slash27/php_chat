<?php
declare(strict_types=1);

namespace Configure;

class Validate
{
    private $p; // $_POST

    /* バリデーションルール */
    private $rules = [
        'name' => [
            'rule' => [
                'null' => [
                    'alert' => '入力必須です。'
                ],
                'maxLength' => [
                    'max' => 16,
                    'alert' => '名前が長すぎます。'
                ]
            ]
        ],
        'message' => [
            'rule' => [
                'null' => [
                    'alert' => '入力必須です。'
                ],
                'maxLength' => [
                    'max' => 256,
                    'alert' => 'メッセージが長すぎます。'
                ]
            ]
        ],
        'passcode' => [
            'rule' => [
                'null' => [
                    'alert' => '入力必須です。'
                ],
                'number' => [
                    'alert' => '半角数字で入力してください。'
                ],
                'maxLength' => [
                    'max' => 4,
                    'alert' => '4桁で入力してください。'
                ],
                'minLength' => [
                    'min' => 4,
                    'alert' => '4桁で入力してください。'
                ]
            ]
        ],
    ];

    /**
     * バリデーション
     *
     * @param array $rule バリデーションルール
     * @return boolean true：エラー無し array $return：エラーメッセージ
     */
    public function main($data) {
        $rules = $this->rules;
        $errors = [];

        foreach ($rules as $field => $val) {
            if (!isset($data[$field]) || !isset($rules[$field]))
                continue;

            $rule = $val['rule'];
            foreach ($rule as $key => $cond) {
                // Postデータとチェック項目を渡し、内容チェック
                $res = $this->checkCond($data[$field], $key, $cond);
                if (!$res)
                    $errors[$field][] = (isset($cond['alert']))? $cond['alert'] : "";
            }
        }

        return ($errors!=[])? $errors : false;
    }

    /**
     * 内容チェック
     * @param val チェックされるデータ
     * @param key チェック項目
     * @param cond 条件
     * @return true:問題なし or false:問題あり
     */
    private function checkCond($val, $key, $cond) {
        // 条件に応じデータをチェック
        switch ($key) {
            case 'null':
                return $this->isNull($val);
                break;
            case 'number':
                return $this->isNumeric($val);
                break;
            case 'maxLength':
                return $this->checkLengthMax($val, $cond['max']);
                break;
            case 'minLength':
                return $this->checkLengthMin($val, $cond['min']);
                break;
            default:
                return false;
        }
    }

    /**
     * nullチェック
     *
     * @param String $str チェック文字列
     * @return boolean true：エラー無し false：validationエラーあり
     */
    private function isNull($str) {
        if ($str == null || strcmp($str, "") == 0) {
            # 文字列が空白の場合、false
            return false;
        }
        return true;
    }

    // /**
    //  * 半角英数＋記号
    //  *
    //  * @param String $str チェック文字列
    //  * @return boolean true：エラー無し false：validationエラーあり
    //  */
    // function isAlphaNumericAndSign($str) {
    //     if (!preg_match("/^[[:graph:]|[:space:]]+$/i", $str)) {
    //         # 半角英数＋記号以外が含まれていた場合、false
    //         return false;
    //     }
    //     return true;
    // }

    /**
     * 半角数字のみ
     *
     * @param String $str チェック文字列
     * @return boolean true：エラー無し false：validationエラーあり
     */
    private function isNumeric($str) {
        if (!preg_match("/^[0-9]+$/", $str)) {
            # 半角数字以外が含まれていた場合、false
            return false;
        }
        return true;
    }

    // /**
    //  * カタカナのみ
    //  *
    //  * @param String $str チェック文字列
    //  * @return boolean true：エラー無し false：validationエラーあり
    //  */
    // function isKatakana($str) {
    //     if (!preg_match("/^[ァ-ヶー　]+$/u", $str)) {
    //         # カタカナ・全角スペース以外が含まれていた場合、false
    //         return false;
    //     }
    //     return true;
    // }

    // /**
    //  * 全角のみ
    //  *
    //  * @param String $str チェック文字列
    //  * @return boolean true：エラー無し false：validationエラーあり
    //  */
    // function isMultiByteChar($str) {
    //     if (!preg_match('/^[^ -~｡-ﾟ\x00-\x1f\t]+$/u', $str)) {
    //         # 全角・全角スペース以外が含まれていた場合、false
    //         return false;
    //     }
    //     return true;
    // }

    // /**
    //  * E-Mailアドレス確認
    //  *
    //  * @param String $input Email欄入力値, String $check Email確認欄入力値
    //  * @return  boolean true：エラー無し false：validationエラーあり
    //  */
    // function chkCollation ($input, $check) {
    //     if ($input != $check) {
    //         return false;
    //     }
    //     return true;
    // }

    // /**
    //  * 郵便番号確認
    //  *
    //  * @param String $input 郵便番号欄入力値
    //  * @return  boolean true：エラー無し false：validationエラーあり
    //  */
    // function isPostal($str) {
    //     if (mb_strlen($str) != 7) {
    //         return false;
    //     }
    //     return true;
    // }

    // /**
    // * 注文商品　選択有無判定
    // * @param array $data POSTデータ注文情報
    // * @return boolean true：エラー無し false：validationエラーあり
    // */
    // function isOrdered($data) {
    //     $total = 0;
	// 		foreach ($data as $kind => $o) {
	// 			if (is_array($o)) {
	// 				foreach ($o as $size => $a) {
	// 					$total += intval($a['amount']);
	// 				}
	// 			}
	// 		}
    //     if ($total <= 0) {
    //         return false;
    //     }
    //     return true;
    // }

    // /**
    // * 支払い方法の条件一致
    // * @param String $str 選択支払い方法, String $mode 選択したお届け先モード
    // * @return boolean true：エラー無し false：validationエラーあり
    // */
    // function paymentChk($str, $mode) {
    //     if (in_array($mode, array('reciever_another','multiple_recievers')) && $str==='0') {
    //         $rtn = false;
    //     } else {
    //         $rtn = true;
    //     }
    //     return $rtn;
    // }

    /**
     * 文字列の長さチェック
     */
    private function checkLengthMax($str, $max) {
        if (mb_strlen($str) > $max) {
            return false;
        }
        return true;
    }

    /**
     * 文字列の長さチェック
     */
    private function checkLengthMin($str, $min) {
        if (mb_strlen($str) < $min) {
            return false;
        }
        return true;
    }
}
?>
