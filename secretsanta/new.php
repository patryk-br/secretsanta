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


if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Loting aanmaken</title>
  <link rel="stylesheet" href="style.css">
<body>
<div>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="lottery.php">Mee doen</a></li>
      <li><a href="new.php">Organiseren</a></li>
      <li><a href="logout.php">Uitloggen</a></li>
    </ul>
  </nav>
  </div>
<div id="container">
<h2>Maak een loting aan</h2>

<form action="dashboard.php" method="post">
  <label for="num_people">Aantal personen</label><br>
  <input type="number" id="num_people" name="num_people" min="1" required><br>
  <div id="people"></div>
  <label for="budget">Budget:</label><br>
  <input type="number" id="budget" name="budget" min="1" required><br>
  <input type="submit" value="Verzenden">
</form>

<script>
  document.getElementById('num_people').addEventListener('change', function() {
    var num_people = this.value;
    var people_div = document.getElementById('people');
    people_div.innerHTML = '';
    for (var i = 1; i <= num_people; i++) {
      var input = document.createElement('input');
      input.type = 'text';
      input.name = 'person' + i;
      input.required = true;
      people_div.appendChild(input);
      people_div.appendChild(document.createElement('br'));
    }
  });
</script>

</body>
</html>