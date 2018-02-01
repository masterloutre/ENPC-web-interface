<?php

include "../Global/connect.php";

  $json_raw = file_get_contents($json_raw);
  $json_data = json_decode($json_raw, true);

  if (isset($json_data['mdp']))
  {
    $mdp = $json_data['mdp'];
    try {
      $db_req = $db->prepare('SELECT mdp
        FROM lancement_jeu
        WHERE phase = 1'
        );
      $db_req->execute();
      $result = $db_req->fetchAll();

      if (!empty($result))
      {
        if ($result[0]['mdp'] == $mdp)
        {
          echo "Mot de passe correct";
        }
        else
        {
          echo "Mot de passe incorrect";
        }
      }
      else {
        echo "Problème de bdd 1";
      }
    }
    catch(PDOException $e) {
      echo "Problème de bdd 2";
    }
  }
  else
  {
    echo "Le serveur n'a pas pu interpréter les données envoyées";
  }
