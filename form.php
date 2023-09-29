<!DOCTYPE html>
<html>
<head>
    <title>Complaint Form</title>
</head>
<body>

<?php
require_once 'connect.php';
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = sanitize_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitize_input($_POST["email"]);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = sanitize_input($_POST["message"]);
    }

    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $sql = "INSERT INTO user (name, email, message) VALUES (:name, :email, :message)";
        $info = [
            $name = $_POST['name'],
            $email = $_POST['email'],
            $message = $_POST['message'],
        ];
        $stmt= $pdo->prepare($sql);
        $stmt->execute($info);
        echo "<h2>Thank you for your message!</h2>";
    }
}
?>

<h2>Contact Us</h2>
<p>Please fill out the form below to forward a message or complaint:</p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name">
    <span class="error"><?php echo $nameErr;?></span>
    <br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email">
    <span class="error"><?php echo $emailErr;?></span>
    <br><br>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="4" cols="50"></textarea>
    <span class="error"><?php echo $messageErr;?></span>
    <br><br>

    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>

