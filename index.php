<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <input type="text" name="name" />
        <button>Submit</button>
    </form>
    <br>
    <?php
  $host = 'localhost';
  $dbname = 'try';
  $username = 'root';
  $password = '';

  $dsn = "mysql:host=$host;dbname=$dbname";
  try {
    $pdo = new PDO($dsn, $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  $stmt = $pdo->query("SELECT * FROM employees");

  echo '<table border="1">' . "\n";
  echo ('<tr> <th>firstName</th> <th>employeeLevel</th> <th>lastName</th></tr>');
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo "<tr><td>";
    echo ($row['firstName']);
    echo "</td><td>";
    echo ($row['employeeLevel']);
    echo ("</td><td>");
    echo ($row['lastName']);
    echo ("</td></tr>\n");

  }

  echo "</table>\n";
  ?>
</body>

</html>