<?php

function sanitize($conn, $value)
{
    return trim(mysqli_real_escape_string(
        $conn,
        htmlspecialchars($value, ENT_QUOTES, "UTF-8") ?? ''
    ));
}
