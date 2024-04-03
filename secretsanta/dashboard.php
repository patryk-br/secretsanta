<?php
  use PHPMailer\PHPMailer\PHPMailer;
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "secretsanta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

// Fetch the email of the logged-in user
$stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$email = $user['email'];


// Fetch the email of the logged-in user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $num_people = $_POST["num_people"];
  $budget = $_POST["budget"];
  $people = array();
  for ($i = 1; $i <= $num_people; $i++) {
    if (isset($_POST["person$i"])) {
      $people[] = $_POST["person$i"];
    }
  }
  shuffle($people);

  // Create a copy of the array and shift it by one position
  $people_copy = $people;
  array_unshift($people_copy, array_pop($people_copy));

  // Pair the corresponding elements of the two arrays
  $pairs_string = "";
  for ($i = 0; $i < $num_people; $i++) {
    $pairs_string .= "{$people[$i]} koopt een cadeau voor {$people_copy[$i]}\n ";
  }
  
  $body = "Secret Santa Pairs:\n$pairs_string\nBudget: $budget";
  // Remove the trailing comma and space
  $pairs_string = rtrim($pairs_string, ", ");

  $body = "De loting is als volgende $pairs_string\nBudget: €$budget";

  require __DIR__ . '/vendor/autoload.php'; 

  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pattbrb@gmail.com';
    $mail->Password = '*';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your-email@gmail.com', 'Secret Santa');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Uw secret santa loting';
    $mail->Body    = $body;

    $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header("refresh:5; url=index.php");
  }
?>

<html>
  <link rel="stylesheet" href="style.css">
<body>
<p> uw loting is aangemaakt. U ontvangt een email met de details. <br> u word automatisch verstuurd naar de homepagina.</p>
</body>
</html>