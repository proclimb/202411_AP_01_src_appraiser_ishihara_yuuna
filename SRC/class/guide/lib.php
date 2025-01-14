<?php

/**
 * 共通で使用できるライブラリ集
 */

/**
 * POSTデータを全て隠し項目に入れる
 *
 * @param $param hidden項目に追加するデータ(要配列)
 * @param $black_list hidden項目に追加したくない項目リスト(要配列)
 */
function hiddenForm($param, $black_list)
{

    // hidden項目に入れたくない物を削除
    // 自formの項目を重ならないようにする為の処置なので
    // 階層構造なのは考慮していない
    $data = $param;
    foreach ($black_list as $key) {
        if (isset($data[$key]) or empty($data[$key])) {
            unset($data[$key]);
        }
    }

    // hidden項目に追加
    hiddenForm2($data);
}

/**
 * 受け取ったデータをhidden項目に追加する
 *
 * @param $param hidden項目に追加するデータ(要配列)
 * @param $name 再帰時に使用するので未指定で良い
 * @param $cnt 同上
 */
function hiddenForm2($param, $name = array(), $cnt = 0)
{
    if ($param != "") {
        if (is_array($param)) {
            foreach ($param as $key => $value) {
                if (is_array($value)) {
                    if ($cnt == 0) {
                        $name[$cnt] = $key;
                    } else {
                        $name[$cnt] = "[$key]";
                    }
                    hiddenForm2($value, $name, $cnt + 1);
                } else {
                    if ($cnt == 0) {
                        $name[$cnt] = $key;
                    } else {
                        $name[$cnt] = "[$key]";
                    }
                    $str = htmlspecialchars($value, ENT_QUOTES);
                    print("<input type=\"hidden\" name=\"" . implode("", $name) . "\" value=\"$str\" />\n");
                }
            }
        } else {
            // ここに来たらデータは渡せなくなる
            $str = htmlspecialchars($value, ENT_QUOTES);
            print("<input type=\"hidden\" name=\"\" value=\"$str\" />\n");
        }
    }
}
