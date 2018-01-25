<form class="" action="index.php?action=login" method="post">
  <p>
  <label for="login">Identifiant</label>
  <input type="text" name="login" value="1704560551">
  </p>

  <p>
  <label for="mdp">Mot de passe</label>
  <input class="w3-input" type="password" name="mdp" value="12345">
  </p>

  <p>
  <label for="user_category">Connexion en tant que</label>
  <select name="user_category">
    <option value="" disabled selected>Veuillez choisir</option>
    <option value="etudiant">Etudiant</option>
    <option value="enseignant">Enseignant</option>
  </select>
  </p>

  <p>
    <input type="submit" value="Envoyer">
  </p>
</form>
