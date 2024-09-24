<?php

require_once "../config/autoload.php";

// Initialize response array
$resp = ['Success' => false, 'Err' => ''];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $username = $_POST['name'] ?? null;
        if (!$username) {
            throw new Exception('Username is required.');
        }
        $username = htmlentities($username);

        // qry
        $params = [$username];
        $qry = "UPDATE {$authType}_users SET user_name = ?";

        if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png', 'image/gif'];
            $maxFileSize = 2 * 1024 * 1024;

            $profileImg = $_FILES['profile'];
            $fileType = mime_content_type($profileImg['tmp_name']);
            $fileSize = $profileImg['size'];

            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception('Invalid file type. Only JPEG, PNG,JPG,WEBP and GIF are allowed.');
            }
            if ($fileSize > $maxFileSize) {
                throw new Exception('File size exceeds the 2MB limit.');
            }

            $fileExt = pathinfo($profileImg['name'], PATHINFO_EXTENSION);
            $newFilename = uniqid('profile_', true) . '.' . $fileExt;
            $filePath = "$baseurl/app/profiles/" . $newFilename;
            $qry .= ",user_profile = ?";
            $params[] = $filePath;

            if (!move_uploaded_file($profileImg['tmp_name'], "$root/app/profiles/" . $newFilename)) {
                throw new Exception('Failed to upload the profile image.');
            }
        }

        $qry .= " WHERE user_id = ?";
        $params[] = $uid;
        $stmt = $db->qry($qry, $params);
        if ($stmt === false) {
            throw new Exception('Something Went Wrong !');
        }
        $resp['Success'] = true;
    } catch (Exception $e) {
        $resp['Err'] = $e->getMessage();
    }
}

echo json_encode($resp);
