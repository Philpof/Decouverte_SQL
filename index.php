<!DOCTYPE html>
<html lang="fr" dir="ltr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Philippe PERECHODOV">
    <title>Découverte SQL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

  </head>

  <body>

    <div class="container">

    <?php

      // Code pour se connecter à la base de données pris sur W3School (https://www.w3schools.com/php/php_mysql_connect.asp)
      $servername = "localhost";
      $username = "root"; // Sauf si le nom à été modifié
      $password = ""; // Champs vide car par de MDP
      $dataBaseName = "decouverte_sql"; // On fait une variable pour le nom de la base de données

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dataBaseName", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully / Connexion effectuée avec succès";
      } catch(PDOException $e) {
        echo "Connection failed / Echec de la connexion : " . $e->getMessage();
      }

      // Code pour afficher tous les noms et prénoms de la base de données
      // $sql = "SELECT * FROM `table 1`"; // Pour avoir ``, c'est AltGR + 7 < il faut utiliser car il y a une espace entre table et 1
      // foreach ($conn -> query($sql) as $row) {
      //   echo $row['first_name'] . " " . $row['last_name'] . '<br>';
      // }

      echo "<hr>";

      // 1. Afficher tous les gens dont le nom est Palmer
      $sql = "SELECT first_name,last_name FROM `table 1` WHERE last_name='Palmer'";
      echo "<div>1. Afficher tous les gens dont le nom est Palmer :<div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";


      // 2. Afficher toutes les femmes
      $sql = "SELECT first_name,last_name FROM `table 1` WHERE gender='Female'";
      echo "<div>2. Afficher toutes les femmes :<div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";

      // 3. Tous les pays (country code) dont la lettre commence par N
      $sql = "SELECT first_name, last_name, country_code FROM `table 1` WHERE country_code LIKE 'N%'";
      echo "<div>3. Tous les pays (country code) dont la lettre commence par N :<div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Country_code</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['country_code'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";


      // 4. Tous les emails qui contiennent google
      $sql = "SELECT first_name, last_name, email FROM `table 1` WHERE email LIKE '%google%'";
      echo "<div>4. Tous les emails qui contiennent google :</div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";


      // 5. Nombre de personne par Pays, classé par ordre croissant
      $sql = "SELECT country_code, COUNT(country_code) FROM `table 1` GROUP BY country_code ORDER BY COUNT(country_code)";
      echo "<div>5. Nombre de personne par Pays, classé par ordre croissant :</div>
      <table class='table table-hover table-striped'>
      <thead>
        <tr>
          <th>Country_code</th>
          <th>Nombre (croissant)</th>
        </tr>
      </thead>
      <tbody>";
      foreach ($conn -> query($sql) as $row) {
        echo "<tr><td>" . $row['country_code'] . "</td>";
        echo "<td>" . $row['COUNT(country_code)'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";


      // 6. Insérer un utilisateur, lui mettre à jour son adresse mail, puis supprimer l’utilisateur

        // Création de l'utilisateur

      $sql = "INSERT INTO `table 1`(id, first_name, last_name, email, gender, ip_address, birth_date, zip_code, avatar_url, state_code, country_code) VALUES ('0','Phil', 'Pof', 'belzepof@gmail.com', 'Male', '666.666.666.666', '24/03/1979', 'ZAP', 'https://www.accesscodeschool.fr/', '03', 'FR')";
      try {
      $stmt = $conn->prepare($sql); // Prepare la declaration
      $stmt->execute(); // execute la requête
        echo "<div>6. Insérer un utilisateur, lui mettre à jour son adresse mail, puis supprimer l’utilisateur :<div>";
        echo "L'utilisateur a bien été créé!";
      }
      catch(PDOException $e) {
        $conn -> rollback();
        echo "Erreur : " . $e->getMessage();
      }

      $sql = "SELECT * FROM `table 1` WHERE last_name LIKE 'Po%'";
      echo "<div>Vérification que l'utilisateur a bien été créé :<div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Gender</th>
            <th>IP Address</th>
            <th>Birth Date</th>
            <th>ZIP Code</th>
            <th>Avatar URl</th>
            <th>State Code</th>
            <th>Country Code</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['ip_address'] . "</td>";
        echo "<td>" . $row['birth_date'] . "</td>";
        echo "<td>" . $row['zip_code'] . "</td>";
        echo "<td>" . $row['avatar_url'] . "</td>";
        echo "<td>" . $row['state_code'] . "</td>";
        echo "<td>" . $row['country_code'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";

        // Changement de l'adresse mail du nouvel utilisateur

      $sql = "UPDATE `table 1` SET email = 'philpof@gmail.com' WHERE last_name='Pof'";
      try {
      $stmt = $conn->prepare($sql); // Prepare la declaration
      $stmt->execute(); // execute la requête
        echo "L'email de l'utilisateur a bien été changé !";
      }
      catch(PDOException $e) {
        $conn -> rollback();
        echo "Erreur : " . $e->getMessage();
      }

      $sql = "SELECT * FROM `table 1` WHERE last_name LIKE 'Po%'";
      echo "<div>Vérification que l'email a bien été changé :<div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Gender</th>
            <th>IP Address</th>
            <th>Birth Date</th>
            <th>ZIP Code</th>
            <th>Avatar URl</th>
            <th>State Code</th>
            <th>Country Code</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['ip_address'] . "</td>";
        echo "<td>" . $row['birth_date'] . "</td>";
        echo "<td>" . $row['zip_code'] . "</td>";
        echo "<td>" . $row['avatar_url'] . "</td>";
        echo "<td>" . $row['state_code'] . "</td>";
        echo "<td>" . $row['country_code'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";

        // CSuppression de l'utilisateur

      $sql = "DELETE FROM `table 1` WHERE last_name='Pof'";
      try {
      $stmt = $conn->prepare($sql); // Prepare la declaration
      $stmt->execute(); // execute la requête
        echo "L'email de l'utilisateur a bien été changé !";
      }
      catch(PDOException $e) {
        $conn -> rollback();
        echo "Erreur : " . $e->getMessage();
      }

      $sql = "SELECT * FROM `table 1` WHERE last_name LIKE 'Po%'";
      echo "<div>Vérification que l'utilsateur à bien été supprimé :<div>
        <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Gender</th>
            <th>IP Address</th>
            <th>Birth Date</th>
            <th>ZIP Code</th>
            <th>Avatar URl</th>
            <th>State Code</th>
            <th>Country Code</th>
          </tr>
        </thead>
        <tbody>";
      foreach  ($conn->query($sql) as $row) {
        echo "<tr><td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['ip_address'] . "</td>";
        echo "<td>" . $row['birth_date'] . "</td>";
        echo "<td>" . $row['zip_code'] . "</td>";
        echo "<td>" . $row['avatar_url'] . "</td>";
        echo "<td>" . $row['state_code'] . "</td>";
        echo "<td>" . $row['country_code'] . "</td></tr>";
      }
      echo "</tbody></table><hr>";


    // 7. Afficher le nombre de femmes et d'hommes et leurs moyennes d’âge

    echo "7. Afficher le nombre de femmes et d'hommes et leurs moyennes d’âge :<br>";
    $sql = "SELECT gender, COUNT(gender) AS MorF, AVG(DATEDIFF(CURRENT_DATE, STR_TO_DATE(birth_date, '%d/%m/%Y'))/365) AS age FROM `table 1` GROUP BY gender";
    echo "<table class='table table-hover table-striped'>
    <thead>
      <tr>
        <th>Gender</th>
        <th>Nombre</th>
        <th>Moyenne d'âge</th>
      </tr>
    </thead>
    <tbody>";
    foreach ($conn -> query($sql) as $row) {
      echo "<tr><td>" . $row['gender'] . "</td>";
      echo "<td>" . $row['MorF'] . "</td>";
      echo "<td>" . $row['age'] . "</td></tr>";
    }
    echo "</tbody></table><hr>";

      // Autre méthode en décomposant les demandes
    $sql = "SELECT COUNT(*) AS hommes FROM `table 1` WHERE gender='Male'";
    echo "Nombre d'hommes :<br>";
    foreach ($conn -> query($sql) as $row) {
      echo $row['hommes'] . "<br>";
    }

    $sql = "SELECT COUNT(*) AS femmes FROM `table 1` WHERE gender='Female'";
    echo "Nombre de femmes :<br>";
    foreach ($conn -> query($sql) as $row) {
      echo $row['femmes'] . "<br>";
    }

    $sql = "SELECT gender, AVG(DATEDIFF(CURRENT_DATE, STR_TO_DATE(birth_date, '%d/%m/%Y'))/365) AS age FROM `table 1` WHERE gender='Male'";
    echo "Moyenne d'âge des hommes :<br>";
    foreach ($conn -> query($sql) as $row) {
      echo $row['age'] . "<br>";
    }

    $sql = "SELECT gender, AVG(DATEDIFF(CURRENT_DATE, STR_TO_DATE(birth_date, '%d/%m/%Y'))/365) AS age FROM `table 1` WHERE gender='Female'";
    echo "Moyenne d'âge des femmes :<br>";
    foreach ($conn -> query($sql) as $row) {
      echo $row['age'] . "<br>";
    }

     ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

   </body>

 </html>
