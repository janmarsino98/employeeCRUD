<?php

require_once "pdo.php";

if (isset($_GET['userToDelete'])) {
    $id = $_GET['userToDelete'];
    $stmt = $pdo->prepare('DELETE from employees WHERE customerID=:customerID');
    $stmt->bindParam(':customerID', $id);
    $stmt->execute();

}

header("location: /trials/user1.php?status=deletesuccess");
exit;