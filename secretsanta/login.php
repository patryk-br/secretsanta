<?php

session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "secretsanta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    $user_data = $result->fetch_assoc();

    $_SESSION['id'] = $user_data['id'];
    $_SESSION['email'] = $user_data['email'];
    $_SESSION['username'] = $user_data['username'];

    header("Location: new.php");
    exit();
  } else {
    echo "Invalid email or password.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="lottery.php">Mee doen</a></li>
      <li><a href="new.php">Organiseren</a></li>
      <li><a href="login.php">Inloggen</a></li>
    </ul>
  </nav>
  </div>
  <div id="container">
    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Wachtwoord:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p>Geen account? <a href="register.php">Maak een account aan</a>.</p>
    <div>
</body>
</html>
