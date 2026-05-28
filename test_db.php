<?php
require_once __DIR__ . '/config/database.php';
if (isset($pdo)) {
    echo "PDO variable exists. Connection OK.";
} else {
    echo "PDO variable NOT found. Check database.php";
}
?>