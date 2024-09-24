<?php

require_once "../../config/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resp = ['Success' => false];

    try {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            $decodedData = json_decode($data, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON data provided.');
            }

            // action
            $action = $_POST['action'] ?? 'hide';
            $fileVisibility = 1;

            if ($action === 'unhide') {
                $passkey = $_POST['passkey'] ?? null;
                if ($passkey) {
                    $k = $user_passkey;
                    if (!password_verify($passkey, $k)) {
                        throw new Exception();
                    }
                    $fileVisibility = 0;
                } else {
                    throw new Exception();
                }
            }

            $placeholders = implode(',', array_fill(0, count($decodedData), '?'));
            $qry = "UPDATE file_uploads SET file_visibility = ? WHERE file_id IN ($placeholders) && file_uploader_id = ?";
            $params = array_merge([$fileVisibility], $decodedData, [$authType . "_" . $uid]);
            $stmt = $db->qry($qry, $params);
            if ($stmt !== false) {
                $resp['Success'] = true;
            } else {
                throw new Exception('Failed to update file visibility.');
            }
        } else {
            throw new Exception('Invalid File');
        }
    } catch (Exception $e) {
        $resp['Err'] = 'Something Went Wrong: ' . $e->getMessage() ;
    }
}

echo json_encode($resp);
