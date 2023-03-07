<?php 
    require "./assets/core/header.php";

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        // requête SQL
        $sql = "SELECT * FROM users WHERE email=:email";

        // Connexion à la base de données
        require "./assets/core/config.php";

        // Préparer la requête
        $query = $lienDB-> prepare($sql);

        // Liaison des paramètres de la requête préparée
        $query-> bindParam(":email", $_POST["email"], PDO::PARAM_STR);
        
        // Exécution de la requête
        if ($query-> execute()) {
            // traitement des résultats
            $results = $query-> fetchAll();

            // débogage des résultats
            var_dump($results);
        } else {
            // echo "<p>Une erreur s'est produite</p>";
        }
    }
?>

<div class="login-box">
  <p>LOGIN</p>
  <form>
    <div class="user-box">
      <input required="" name="" type="text">
      <label>Email</label>
    </div>
    <div class="user-box">
      <input required="" name="" type="password">
      <label>Password</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Submit
    </a>
  </form>
  <p>Don't have an account? <a href="./register.php" class="a2">Sign up!</a></p>
</div>

<?php 
    require "./assets/core/footer.php"
?>