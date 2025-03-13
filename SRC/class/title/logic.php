<?php

//
// タイトル管理画面
//
function subFTitle()
{
    $param = getFTitleParam();

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (! $param["orderBy"]) {
        $param["orderBy"] = 'CLASSNO,SEQNO';
        $param["orderTo"] = 'asc';
    }

    subMenu();
    subFTitleView($param);
}

//
// 項目管理画面
//
function subFTitleItem()
{
    $param = getFTitleParam();

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (! $param["orderBy"]) {
        $param["orderBy"] = 'CLASSNO,SEQNO';
        $param["orderTo"] = 'asc';
    }
    $param["sClassNo"] = htmlspecialchars($_REQUEST['sClassNo']);
    $param["sDocNo"] = htmlspecialchars($_REQUEST['sDocNo']);

    subMenu();
    subFTitleItemView($param);
}

//
// タイトル管理編集画面
//
function subFTitleEdit()
{
    $param = getFTitleParam();

    $param["DocNo"] = htmlspecialchars($_REQUEST['docNo']);

    if ($param["DocNo"]) {
        $sql = fnSqlFTitleEdit($param["DocNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["DocNo"] = htmlspecialchars($row[0]);
        $param["classNo"] = htmlspecialchars($row[1]);
        $param["seqNo"] = htmlspecialchars($row[2]);
        $param["name"] = htmlspecialchars($row[3]);

        $param["purpose"] = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    if ($param["sDocNo"]) {
        subFTitleItemEditView($param);
    } else {
        subFTitleEditView($param);
    }
}

//
// タイトル管理編集完了処理
//
function subFTitleEditComplete()
{
    $param = getFTitleParam();

    $param["DocNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['DocNo']);
    $param["classNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['classNo']);
    $param["seqNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['seqNo']);
    $param["name"] = mysqli_real_escape_string($param["conn"], $_REQUEST['name']);
    $param["sClassNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['sClassNo']);

    $ErrClassNo = subFTitleRepetition($param["classNo"], $param["DocNo"]);

    if ($param["DocNo"]) {
        if ($param["seqNo"] == 0) {
            // タイトルの更新処理
            if (! $ErrClassNo) {
                // 更新前の情報を取得
                $sql = fnSqlFTitleEdit($param["DocNo"]);
                $res = mysqli_query($param["conn"], $sql);
                $row = mysqli_fetch_array($res);

                $beforeClassNo = htmlspecialchars($row[1]);

                // タイトルの更新
                $sql = fnSqlFTitleUpdate($param);
                $res = mysqli_query($param["conn"], $sql);

                // 紐付く項目を取得
                $sql = fnSqlFTitleRepetition($beforeClassNo);
                $result = mysqli_query($param["conn"], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['SEQNO'] !== '0') {
                        $param["DocNo"] = $row['DOCNO'];
                        // $param["classNo"] = $row['CLASSQNO'];
                        $param["seqNo"] = $row['SEQNO'];
                        $param["name"] = $row["NAME"];
                        $sql = fnSqlFTitleItemUpdate($param);
                        $ret = mysqli_query($param["conn"], $sql);
                    }
                }
                subTitlePage0();
            } else {
                // 重複時
                $param["purpose"] = '更新';
                $param["btnImage"] = 'btn_load.png';
                subFTitleMsg($param);
            }
        } else {
            $sql = fnSqlFTitleUpdate($param);
            $res = mysqli_query($param["conn"], $sql);
            subTitlePage1();
        }
    } else {
        $param["DocNo"] = fnNextNo('DOC');
        if (! $param["seqNo"]) {

            if (! $ErrClassNo) {
                $param["seqNo"] = 0;
                $sql = fnSqlFTitleInsert($param);
                $res = mysqli_query($param["conn"], $sql);
                $param["ttl_flg"] = 0;
            } else {
                $param["DocNo"] = "";
                $param["purpose"] = '登録';
                $param["btnImage"] = 'btn_enter.png';
                subFTitleMsg($param);
            }
            subTitlePage0();
        } else {
            $sql = fnSqlFTitleInsert($param);
            $res = mysqli_query($param["conn"], $sql);
            subTitlePage1();
        }
    }
}

//
// 画面振り分け
//
function subTitlePage0()
{
    $_REQUEST['act'] = 'fTitleSearch';
    subFTitle();
}

function subTitlePage1()
{
    $_REQUEST['act'] = 'fTitleItemSearch';
    subFTitleItem();
}

//
// タイトル管理削除処理
//
function subFTitleDelete()
{
    $conn = fnDbConnect();

    $DocNo = $_REQUEST['DocNo'];

    if ($_REQUEST['seqNo'] == 0) {
        $sql = fnSqlFTitleRepetition($_REQUEST['classNo']);
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($res)) {
            $sql = fnSqlFTitleDelete($row['DOCNO']);
            $result = mysqli_query($conn, $sql);
        }
    } else {
        $sql = fnSqlFTitleDelete($DocNo);
        $res = mysqli_query($conn, $sql);
    }

    $_REQUEST['act'] = 'fTitleSearch';
    subFTitle();
}

//
// 画面間引継ぎ情報
//
function getFTitleParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];

    return $param;
}

//
// 項目名管理編集画面
//
function subFTitleItemEdit()
{
    $param = getFTitleParam();

    $param["DocNo"] = htmlspecialchars($_REQUEST['docNo']);
    $param["sDocNo"] = htmlspecialchars($_REQUEST['sDocNo']);
    $param["sClassNo"] = htmlspecialchars($_REQUEST['sClassNo']);

    if ($param["DocNo"]) {
        $sql = fnSqlFTitleEdit($param["DocNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["DocNo"] = htmlspecialchars($row[0]);
        $param["classNo"] = htmlspecialchars($row[1]);
        $param["seqNo"] = htmlspecialchars($row[2]);
        $param["name"] = htmlspecialchars($row[3]);

        $param["purpose"] = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subFTitleItemEditView($param);
}

//
// 重複チェック
//
function subFTitleRepetition($classNo, $DocNo)
{
    $conn = fnDbConnect();

    $sql = fnSqlFTitleRepetition($classNo);
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($res)) {
        if ($row['CLASSNO'] == $classNo && $row['SEQNO'] == 0) {
            if ($row['DOCNO'] !== $DocNo) {
                return $row['CLASSNO'];
            }
        }
    }
}

//
// エラー表示
//
function subFTitleMsg($param)
{
    $param["classNoChk"] = "既に登録されている表示順です";
    $sql = fnSqlFTitleEdit($param["DocNo"]);
    $res = mysqli_query($param["conn"], $sql);
    // $param["classNo"] = mysqli_result( $res,0,1 );
    $row = mysqli_fetch_array($res);
    $param["classNo"] = $row[1];

    $_REQUEST['act'] = 'fTitleEdit';
    subMenu();
    subFTitleEditView($param);
    print "</body>\n</html>";
    exit();
}
