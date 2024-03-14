<?php

echo "<pre>\n";
require_once "pdo.php";

$stmt = $pdo->query("SELECT * from emplyees");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}

echo "</pre>\n";