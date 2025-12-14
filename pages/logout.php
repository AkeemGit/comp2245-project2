<?php
session_start();

if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
}

echo json_encode(["status" => "success"]);
exit;
?>