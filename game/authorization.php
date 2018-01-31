<?php

include "../Global/connect.php";

  $json_data = json_decode(file_get_contents('php://input'), true);
  if (isset($json_data))
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
          echo 1;
        }
        else
        {
          echo 0;
        }
      }
      else {
        echo 0;
      }
    }
    catch(PDOException $e) {
      echo 0;
    }
  }
  else
  {
    return -1;
  }
