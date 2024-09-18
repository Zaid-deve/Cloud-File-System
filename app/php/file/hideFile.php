<?php

require_once "../../config/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            $decodedData = json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception();
            }

            // hide files
            $placeholders = implode(',', array_fill(0, count($decodedData), '?'));
            $qry = "UPDATE file_uploads SET file_visibility = ? WHERE file_id IN ($placeholders) && file_uploader_id = ?";
            $params = array_merge([1], $decodedData, [$uid]);
            $stmt = $db->qry($qry, $params);
            if ($stmt !== false) {
                $resp['Success'] = true;
            } else {
                throw new Exception();
            }
        }
    } catch (Exception $e) {
        $resp['Err'] = 'Something Went Wrong !' . $db->getErr();
    }
}

echo json_encode($resp);
