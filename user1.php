<?php

require_once "pdo.php";

if (isset($_GET['status']) && $_GET['status'] == 'updatesuccess') {
    echo 'Your record was successfully updated.';
} else if (isset($_GET['status']) && $_GET['status'] == 'deletesuccess') {
    echo 'Your record was successfully deleted.';
}

if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['salary'])) {


    //Check name and lastname format
    $alph_pattern = '/^[A-Za-z]+(\s[A-Za-z]+)*$/';

    if (!preg_match($alph_pattern, $_POST['firstName']) || !preg_match($alph_pattern, $_POST['lastName'])) {
        echo "<script>alert('The first name or last name are not valid'); window.location = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    }

    // Check number format
    $num_pattern = '/^\d+$/';
    if (!preg_match($num_pattern, $_POST['salary'])) {

        echo "<script>alert('Invalid number format'); window.location = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();

    }


    // Set employee level according to salary
    if ($_POST['salary'] < 30000) {
        $employeeLevel = 1;
    } else if ($_POST['salary'] < 60000) {
        $employeeLevel = 2;
    } else {
        $employeeLevel = 3;
    }




    $sql = "INSERT INTO employees (firstName, lastName, salary, employeeLevel) VALUES (:firstName, :lastName, :salary, :employeeLevel)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array(
            ':firstName' => $_POST['firstName'],
            ':lastName' => $_POST['lastName'],
            ':salary' => $_POST['salary'],
            ':employeeLevel' => $employeeLevel
        )
    );

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="navcontainer">
        <nav>
            <div class="navoption tab1 selected" id="tab1option">Add Employee</div>
            <div class="navoption tab2" id="tab2option">Search Employees</div>
        </nav>
    </div>
    <br>

    <div class="container" id="tab1container">
        <form action="/trials/user1.php" method="POST">
            <div class="form-group">
                <label for="firstName" id="firstName">First Name</label>
                <input type="text" name="firstName" required class="form-control">
            </div>
            <div class="form-group">
                <label for="lastName" id="lastName">Last Name</label>
                <input type="text" name="lastName" required class="form-control">
            </div>
            <div class="form-group">
                <label for="salary" id="salary">Salary</label>
                <input type="text" name="salary" id="salary" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <div class="container" id="tab2container" hidden>
        <form action="" method="GET">
            <div class="form-group">
                <label for="search">Search an Employee:</label>
                <input type="text" name="search" class="form-control">

            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <br>

        <?php
        if (isset($_GET['search'])) {

            // If no text -> select all registers of the employees table
            if ($_GET['search'] === "") {
                $sql = "SELECT * FROM employees";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            } else {
                $sql = "SELECT * FROM employees WHERE (customerID=:search OR lastName=:search OR employeeLevel=:search)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(
                    array(
                        ':search' => $_GET['search']
                    )
                );
            }

            if ($stmt->rowCount() > 0) {

                echo '<br>';
                echo '<table style="width:auto" class="table">';
                echo '<thead><tr>';
                echo '<th scope="col" >Customer ID</th>';
                echo '<th scope="col" >First Name</th>';
                echo '<th scope="col" >Last Name</th>';
                echo '<th scope="col" >Salary</th>';
                echo '<th scope="col" >Level</th>';
                echo '</tr></thead>';
                echo '<tbody>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>";
                    echo ($row['customerID']);
                    echo "</td><td>";
                    echo ($row['firstName']);
                    echo "</td><td>";
                    echo ($row['lastName']);
                    echo "</td><td>";
                    echo ($row['salary']);
                    echo "</td><td>";
                    echo ($row['employeeLevel']);
                    echo "</td><td>";
                    echo ("<a class='btn btn-primary' href='/trials/modification.php?userToModifyId=$row[customerID]'>Update</a>");
                    echo "</td><td>";
                    echo ("<a class='btn btn-danger' href='/trials/delete.php?userToDelete=$row[customerID]'>Delete</a>");
                    echo "</td>";
                }
                echo '</tbody>';
                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }
        }
        ?>
    </div>


    <?php if (isset($_GET['search'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Directly show Tab2 and hide Tab1
                document.getElementById('tab1container').hidden = true;
                document.getElementById('tab2container').hidden = false;

                // Adjust active tab indicator as necessary
                document.getElementById('tab1option').classList.remove('selected');
                document.getElementById('tab2option').classList.add('selected');
            });
        </script>
    <?php endif; ?>


    <script src="app.js"></script>
</body>


</html>