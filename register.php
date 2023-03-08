<?php 
    require "./assets/core/header.php";

    // isset() permet de vérifier qu'une variable est initialisée (is set)
    // retourne un booléen :
    // - vrai/true si la variable a été initialisée (et existe donc)
    // - faux/false dans le cas contraire
    // Nous testons ici successivement les trois champs obligatoires
    if (isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"]))  {
        // Les deux mots de passes sont identiques ?
        if ($_POST["password1"] == $_POST["password2"]) {
          echo 1;
          // Si les deux mots de passes sont bien identiques,
            // nous pouvons continuer ...
            $email = $_POST["email"];
            
            // Il n'est absolument pas nécessaire de stocker
            // le mot de passe de confirmation
            $password = $_POST["password1"];
            // A remplacer pour hasher le mot de passe par:
            $options = [
                'cost' => 12,
              ];
            $password = password_hash($_POST["password1"], PASSWORD_BCRYPT, $options);
              echo 2;
            // Traitement des données facultatives du formulaire
            if (isset($_POST["firstname"])) {
                $firstName = $_POST["firstname"];
            } else {
                $firstName = "";
            }
            
            if (isset($_POST["lastname"])) {
              $lastName = $_POST["lastname"];
            } else {
              $lastName = "";
            }
            if (isset($_POST["datenaissance"])) {
                $dateDeNaissance = $_POST["datenaissance"];
                echo 3;
            } else {
                $dateDeNaissance = "";
            }
/** Nous pouvons maintenant stocker les données en base de données */ 

            // Connexion à la base de données
            require "./assets/core/config.php";
            if ($dsn) { 
              echo 'la connexion s\'est faite';
            } else {
              echo 'non';
            }
            // Requête SQL
            // $sql = "INSERT INTO users (email, password, firstname, lastname) VALUES ('$email', '$password', '$firstName', '$lastName', '$dateDeNaissance);";
            // devient, notez la disparition des guillemets simples
            $sql = "INSERT INTO utilisateur (email, password, firstname, lastname) VALUES (:email, :password, :firstname, :lastname);";
            
            // Préparer la requête
            $query = $lienDB-> prepare($sql);
            
            // Liaison des paramètres de la requête préparée
            $query-> bindParam(":email", $email, PDO::PARAM_STR);
            $query-> bindParam(":password", $password, PDO::PARAM_STR);
            $query-> bindParam(":firstname", $firstName, PDO::PARAM_STR);
            $query-> bindParam(":lastname", $lastName, PDO::PARAM_STR);
            $query-> bindParam(":datenaissance", $dateDeNaissance, PDO::PARAM_INT);

            // Exécution de la requête
            if ($query-> execute()) {
              echo "<p>Le compte a bien été créé</p>";
            } else {
              echo "<p>Une erreur s'est produite</p>";
              var_dump($query->errorInfo());
            }
        } else {
            // Les deux mots de passes saisis sont différents
            echo "<p>mots de passe différents</p>";
        }
    } else {
        // echo "<p>Champs obligatoires absents</p>";
    }
    ?>

<div class="login-box">
  <p>Register</p>
  <form action="./login.php" method="post" >
    <div class="user-box">
      <input name="firstname" type="text">
        <label>Prénom</label>
      </div>
      <div class="user-box">
        <input name="lastname" type="text">
        <label>Nom</label>
      </div>
      <div class="user-box">
        <!-- pour pouvoir supprimer la date en placeholder -->
        <input name="datenaissance" type="text" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'">
        <label>Date de naissance</label>
      </div>
      <div class="user-box">
      <input required="" name="email" type="text">
      <label>Email</label>
    </div>
    <div class="user-box">
      <input required="" name="password1" type="password">
      <label>Password</label>
    </div>
    <div class="user-box">
      <input required="" name="password2" type="password">
      <label>Confirmez votre password</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <button type="submit">Envoyer</button>
    </a>
  </form>
</div>

<?php 
    require "./assets/core/footer.php";
    var_dump($_POST);
    ?>