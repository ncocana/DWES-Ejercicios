<?php
echo "<h1>Queries PDO</h1>";
include_once "./database.php";
$database = new Database();
$pdo = $database->getConnection();
$stmt1 = $pdo->query('SELECT id, firstname, lastname FROM users');
echo "<h2>Query 1 - 'SELECT id, firstname, lastname FROM users'</h2>";
while ($row = $stmt1->fetch())
{
    echo "<p>" . $row['id'] . " - " . $row['firstname'] . " " . $row['lastname'] . "</p>";
}

$email="%gmail%";
$status=1;
$stmt2 = $pdo->prepare('SELECT * FROM users WHERE email LIKE :email AND status=:status');
$stmt2->execute(['email' => $email, 'status' => $status]);
echo "<h2>Query 2 - 'SELECT * FROM users WHERE email LIKE :email AND status=:status'</h2>";
foreach ($stmt2 as $row)
{
    echo "<p>" . $row['id'] . " - " . $row['firstname'] . " " . $row['lastname'] . "</p>";
}
?>
