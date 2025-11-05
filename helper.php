<?php

function uploadPhoto(string $inputName, string $folder): ?string
{
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($_FILES[$inputName]['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {

        echo json_encode([
            'status' => false,
            'message' => ['Wrong file type']
        ]);
        exit;
    }

    $uploadDir = __DIR__ . "/assets/uploads/{$folder}/";

    if (!is_dir($uploadDir)) {

        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid('', true) . '_' . basename($_FILES[$inputName]['name']);
    $uploadPath = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadPath)) {

        echo json_encode([
            'status' => false,
            'message' => [' uploads error']
        ]);
        exit;
    }

    return "uploads/{$folder}/" . $fileName;
}

function jsonStatus(bool $status, string|array $message){


   echo json_encode([

        'status'=> $status,
        'message'=>$message

    ]);
}
