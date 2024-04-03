<!DOCTYPE html>
<html>
<head>
  <title>Signup Form</title>
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
  <h2>Maak eenvoudig een account aan, of<a href=login.php> Log in</a></h2>
  <form method="POST" action="register.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    
    <input type="submit" value="Sign Up">
</div>
  </form>
</body>
</html>


<?php
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $servername = "localhost";
  $db_username = "root";
  $db_password = "";
  $dbname = "secretsanta";

  $conn = new mysqli($servername, $db_username, $db_password, $dbname);



  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


  $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

  if ($conn->query($sql) === TRUE) {


  
    $mail = new PHPMailer(true);

    try {
   
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'pattbrb@gmail.com'; 
      $mail->Password = '*'; 
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      //Recipients
      $mail->setFrom('pattbrb@gmail.com', 'Secret Santa');
      $mail->addAddress($email, $username); 

      //Content
      $mail->isHTML(true);
      $mail->Subject = 'Registratie sucessvol';
      $mail->Body = 'Uw registratie is sucessvol. U kunt nu inloggen op de website.
      Wanneer u een loting aanmaakt, krijgt u op dit emailadres de lijst met deelnemers toegestuurd.';

      $mail->send();
      echo "Email sent successfully";

    
      header("Location: sucess.php");
      exit;
    } catch (Exception $e) {
      echo "Failed to send email. Error: " . $mail->ErrorInfo;
    }
  }
  $conn->close();
}
?>
