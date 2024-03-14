<?php

//Configure database
$host = "localhost";
$username = "root";
$password = "";
$db_name = "try";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Read json file
$jsonData = file_get_contents("customer.json");
$data = json_decode($jsonData, true);

//SQL to create the table
$createQuery = "CREATE TABLE IF NOT EXISTS employees (
    customerID INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(100),
    lastName VARCHAR(100),
    salary DECIMAL,
    employeeLevel VARCHAR(100)
)";

if (!$conn->query($createQuery)) {
    die("Error creating table: " . $conn->error);
}

//Insert data into the table
$insertQuery = $conn->prepare("INSERT INTO employees (customerID, firstName, lastName, salary, employeeLevel) VALUES (?, ?, ?, ?, ?)");
foreach ($data as $item) {
    $customerID = $item['empId']; // Mapping 'empId' from JSON to 'customerID'
    $firstName = $item['empFirstname']; // Mapping 'empFirstname' to 'firstName'
    $lastName = $item['empLastname']; // Mapping 'empLastname' to 'lastName'
    $salary = $item['empSalary']; // Mapping 'empSalary' to 'salary'
    $employeeLevel = floatval($item['empLevel']); // Mapping 'empLevel' to 'employeeLevel' and ensuring it's a float

    $insertQuery->bind_param("issdd", $customerID, $firstName, $lastName, $salary, $employeeLevel);
    $insertQuery->execute();
}

//Close connection

$conn->close();