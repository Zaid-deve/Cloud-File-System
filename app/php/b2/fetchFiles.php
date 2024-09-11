<?php


require_once "../../config/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $filter = htmlentities($_POST['filter']) ?? null;
    $passKey  = htmlentities($_POST['passKey']) ?? null;
    $hiddenQry = $filterQry = '';
    $params = [$uid];


    // is requesting hidden
    if ($passKey) {
        if (strlen($_POST['filter']) < 6) {
            $resp['Err'] = "Invalid Passkey !";
            die(json_encode($resp));
        }

        $stmt = $db->qry("SELECT pass_key FROM {$authType}_users WHERE user_id = ?", [$uid]);
        if ($stmt) {
            $key = $stmt['pass_key'];
            if (!$key) {
                $resp['Err'] = "Something went wrong !";
                die(json_encode($resp));
            }

            if ($key != $passKey) {
                $resp['Err'] = "Passkey does not match !";
                die(json_encode($resp));
            }

            $hiddenQry = " AND file_visibility = ?";
            $params[] = 1;
        } else {
            $resp['Err'] = "Something went wrong !";
            die(json_encode($resp));
        }
    }

    if ($filter) {
        $filterQry = " AND file_name LIKE %{?}%";
        $params[] = $filter;
    }

    $files = $db->qry("SELECT file_name name, file_size size, file_type type, file_id id, file_last_viewed recent FROM file_uploads WHERE file_uploader_id = ? $hiddenQry $filterQry", $params);

    if ($files !== false) {
        $resp['Success'] = true;
        $resp['Files'] = $files;
    } else {
        $resp['Err'] = $db->getErr();
    }
}

echo json_encode($resp);
