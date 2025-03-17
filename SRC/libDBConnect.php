<?php

//
// ★　ログイン（ハッシュ化ver）
//
function fnSqlLogin($id) // $id(ユーザーのログインID)を使ってデータベース内のユーザーを検索し、ログイン認証を行うためのSQLクエリを作成
{
    $id = addslashes($id); // addslashes($id) は、ユーザーIDに含まれる特殊文字（例: ' や "）をエスケープする。これにより、SQLインジェクション攻撃を防ぐためにSQLクエリ内で特殊文字が適切に処理される
    $sql = "SELECT USERNO,AUTHORITY FROM TBLUSER"; // TBLUSER テーブルから、USERNOと AUTHORITYを取得するSQLクエリ
    $sql .= " WHERE DEL = 1"; // 削除されていないユーザー（DEL=1）だけを対象にする条件
    $sql .= " AND ID = '$id'"; // ユーザーIDが $id の値と一致するユーザーを選択する条件

    return ($sql);
}

//
// ★　ログイン
//
// function fnSqlLogin($id, $pw)
// {
// $id = addslashes($id);
// $sql = "SELECT USERNO,AUTHORITY FROM TBLUSER";
// $sql .= " WHERE DEL = 1";
// $sql .= " AND ID = '$id'";
// $sql .= " AND PASSWORD = '$pw'";

// return ($sql);
// }

//
// ユーザー情報リスト
//
function fnSqlAdminUserList()
{
    $sql = "SELECT USERNO,NAME,ID,PASSWORD,AUTHORITY FROM TBLUSER";
    $sql .= " WHERE DEL = 1";
    $sql .= " ORDER BY AUTHORITY ASC,NAME ASC";

    return ($sql);
}

//
// ユーザー情報詳細
//
function fnSqlAdminUserEdit($userNo)
{
    $sql = "SELECT NAME,ID,PASSWORD,AUTHORITY FROM TBLUSER";
    $sql .= " WHERE USERNO = $userNo";

    return ($sql);
}

//
// ユーザー情報更新
//
function fnSqlAdminUserUpdate($userNo, $name, $id, $password, $authority)
{
    if ($password !== "") { // パスワードが空でない場合、パスワードをハッシュ化する
        $pass = password_hash($password, PASSWORD_DEFAULT); // パスワードをハッシュ化して、変数 $pass に格納
    }
    $sql = "UPDATE TBLUSER"; // SQL文の基本部分（TBLUSERテーブルの更新）
    $sql .= " SET NAME = '$name'"; // ユーザーの名前（NAME）を更新
    $sql .= ",ID = '$id'"; // ユーザーID（ID）を更新
    if ($password !== "") { // パスワードに値が入っていた場合、PASSWORDを更新
        $sql .= ",PASSWORD = '$pass'"; // ハッシュ化されたパスワードで更新
    }
    $sql .= ",AUTHORITY = '$authority'"; // ユーザーの権限（AUTHORITY）を更新
    $sql .= ",UPDT = CURRENT_TIMESTAMP"; // 更新日時（UPDT）を現在の日時に設定
    $sql .= " WHERE USERNO = '$userNo'"; // 更新対象のユーザーを特定するため、USERNO（ユーザー番号）を条件に指定

    return ($sql); // 完成したSQL文を返す
}

//
// ★　ユーザー情報登録（ハッシュ化ver）
//
function fnSqlAdminUserInsert($userNo, $name, $id, $password, $authority)
{
    $pass = password_hash($password, PASSWORD_DEFAULT); // 渡されたパスワード（$password）をpassword_hash()関数を使ってハッシュ化
    $sql = "INSERT INTO TBLUSER("; // TBLUSERテーブルにデータを挿入
    $sql .= "USERNO,NAME,ID,PASSWORD,AUTHORITY,INSDT,UPDT,DEL"; // 挿入するカラム名を指定
    $sql .= ")VALUES(";
    $sql .= "'$userNo','$name','$id','$pass','$authority',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)"; // 上記のすべての情報をTBLUSERテーブルに挿入

    return ($sql); // 作成したSQLクエリを返す
}


//
// ★　ユーザー情報登録
//
// function fnSqlAdminUserInsert($userNo, $name, $id, $password, $authority)
// {
// $pass = addslashes(hash('adler32', $password));
// $sql = "INSERT INTO TBLUSER(";
// $sql .= "USERNO,NAME,ID,PASSWORD,AUTHORITY,INSDT,UPDT,DEL";
// $sql .= ")VALUES(";
// $sql .= "'$userNo','$name','$id','$pass','$authority',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

// return ($sql);
// }

//
// ユーザー情報削除
//
function fnSqlAdminUserDelete($userNo)
{
    $sql = "UPDATE TBLUSER";
    $sql .= " SET DEL = 0";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE USERNO = '$userNo'";

    return ($sql);
}

//
// 次の番号を得る
//
function fnNextNo($t)
{
    $conn = fnDbConnect();

    $sql = "SELECT MAX(" . $t . "NO) FROM TBL" . $t;
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    if ($row[0]) {
        $max = $row[0] + 1;
    } else {
        $max = 1;
    }

    return ($max);
}
