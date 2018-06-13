<?php

require "./Global/global.php";
require_once "./Models/Etudiant.php";
require_once "./Models/Enseignant.php";
require_once "./Controllers/EtudiantController.php";
require_once "./Controllers/EnseignantController.php";

function create_token($data) {
   $tokenGeneric = "EnPCMillén4aire";
   $random_var = rand();

   /* Encoding token */
   $token = hash('sha256', $tokenGeneric.$data.$random_var);

   return $token;
}

function start()
{
  if(session_status() == PHP_SESSION_NONE){
      session_start();
  }
}

function who_is_logged_in()
{
  include "./Global/connect.php";
  try {
      if(!isset($_SESSION['user_session'])){
         return false;
      }
    $db_req = $db->prepare(
      'SELECT id
       FROM enseignant
       WHERE token = "'.$_SESSION['user_session'].'"'
      );
    $db_req->execute();
    $result = $db_req->fetchAll();

    if ($db_req->rowCount() > 0)
    {
      $user = get_enseignant($db, $result[0]['id']);
      return $user;
    }
    else
    {
      $db_req = $db->prepare(
        'SELECT id
         FROM etudiant
         WHERE token = "'.$_SESSION['user_session'].'"'
        );
      $db_req->execute();
      $result = $db_req->fetchAll();

      if ($db_req->rowCount() > 0)
      {
        $user = get_etudiant($db, $result[0]['id']);
        return $user;
      }
    }
    return false;
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function etudiant_logged_in()
{
  if (who_is_logged_in() instanceof Etudiant)
    return true;
  else
    return false;
}

function enseignant_logged_in()
{
  if (who_is_logged_in() instanceof Enseignant)
    return true;
  else
    return false;
}

function admin_logged_in()
{
  if (who_is_logged_in() instanceof Enseignant && who_is_logged_in()->get_admin() == true)
    return true;
  else
    return false;
}
