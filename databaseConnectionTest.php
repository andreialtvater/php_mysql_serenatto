<?php

require_once __DIR__ . '/Database/DB.php';

try {
    $db = DB::getInstance()->getConnection();
    var_dump($db);
    echo "Connection Established Successfully!";
} catch (PDOException $e) {
    echo "Connection ERROR: " . $e->getMessage();
}