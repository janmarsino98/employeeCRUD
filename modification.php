<?php
require_once "pdo.php";

$user = null;

if (isset($_GET['userToModifyId'])) {

    $user_id = $_GET['userToModifyId'];

    $stmt = $pdo->prepare('SELECT * FROM employees WHERE customerID = :user_id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "There is no existent user with that id";
        exit();
    }
}


if (isset($_POST['userid'])) { // Assuming 'userID' is the correct field name in your form now

    $customerId = $_POST['userid']; // Make sure this matches the form field's name
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $salary = $_POST['salary'];


    // Determine employeeLevel based on salary
    $employeeLevel = ($salary < 30000) ? 1 : (($salary < 60000) ? 2 : 3);

    $stmt = $pdo->prepare('UPDATE employees SET firstName = :firstName, lastName = :lastName, salary = :salary, employeeLevel = :employeeLevel WHERE customerID = :customerID');
    $stmt->bindParam(':customerID', $customerId);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':salary', $salary);
    $stmt->bindParam(':employeeLevel', $employeeLevel);

    if ($stmt->execute()) {
        echo "Record updated successfully";
        header("location:/trials/user1.php?status=updatesuccess");
        exit();

    } else {
        echo "The record could not be updated";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify user</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container" id="tab1container">
        <form action="modification.php" method="POST">
            <input type="text" name="userid" value="<?php echo $user_id ?>" hidden>
            <div class="form-group">
                <label for="firstName" id="firstName">First Name</label>
                <input type="text" name="firstName" required class="form-control" value="<?php if (isset($user['firstName'])) {
                    echo $user['firstName'];
                } else {
                    echo '';
                }
                ?>">
            </div>
            <div class="form-group">
                <label for="lastName" id="lastName">Last Name</label>
                <input type="text" name="lastName" required class="form-control" value="<?php if (isset($user['lastName'])) {
                    echo $user['lastName'];
                } else {
                    echo '';
                }

                ?>">
            </div>
            <div class="form-group">
                <label for="salary" id="salary">Salary</label>
                <input type="text" name="salary" id="salary" required class="form-control" value="<?php if (isset($user['salary'])) {
                    echo $user['salary'];
                } else {
                    echo '';
                }

                ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>