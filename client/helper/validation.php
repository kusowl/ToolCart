<?php
function isExistDB($conn, $table, $fieldName, $value): bool
{
    $result = mysqli_query($conn, "SELECT $fieldName FROM $table WHERE $fieldName = $value");
    return mysqli_num_rows($result) > 0;
}
