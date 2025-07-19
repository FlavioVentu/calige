<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Registrazione</title>
</head>
<body>
  <h2>Modulo di Registrazione</h2>
  <form action="http://localhost/backend/registration.php" method="POST">
    <label for="firstname">Nome:</label><br>
    <input type="text" id="firstname" name="firstname" required><br><br>

    <label for="lastname">Cognome:</label><br>
    <input type="text" id="lastname" name="lastname" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="pass">Password:</label><br>
    <input type="password" id="pass" name="pass" required><br><br>

    <label for="confirm">Conferma password:</label><br>
    <input type="password" id="confirm" name="confirm" required><br><br>

    <button type="submit">Registrati</button>
  </form>
</body>
</html>
