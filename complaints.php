<?php
require_once 'connect.php';
$sql = "SELECT ID, name, email, message FROM user";

// Execute the query
try {
    $stmt = $pdo->query($sql);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Complaints</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Customer complaints</h2>

<?php

if ($stmt->rowCount() > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th></tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['message']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No data found.';
}
?>

</body>
</html>
