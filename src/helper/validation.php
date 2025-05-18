<?php

function isExistDB($conn, $table, $fieldName, $value): bool
{
    $result = mysqli_query($conn, "SELECT $fieldName FROM $table WHERE $fieldName = $value");
    return mysqli_num_rows($result) > 0;
}

function validateFile($file, $fileTypes, $fileSize)
{
    if ($file['error'] != UPLOAD_ERR_OK)
        return 1;
    // Check file type
    if (!in_array($file['type'], $fileTypes))
        return 2;

    if ($file['size'] > $fileSize)
        return 3;

    return 0;
}
