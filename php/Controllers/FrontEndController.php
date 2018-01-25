<?php

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Etudiant.php";
require_once "../Models/Enseignant.php";

function login()
{
  include "../Global/connect.php";

  if (isset($_POST["user_category"]) && isset($_POST["mdp"]) && isset($_POST["login"]))
  {
    $category = $_POST["user_category"];
    $login = $_POST["login"];
    $password = $_POST["mdp"];
    try
    {
       if ($category == 'enseignant')
       {
         $db_req = $db->prepare('SELECT *
         FROM enseignant
         WHERE enseignant.login = "'.$login.'"
         LIMIT 1');
       }
       else if ($category == 'etudiant')
       {
         $db_req = $db->prepare('SELECT *
         FROM etudiant
         WHERE etudiant.num_etud = '.$login.'
         LIMIT 1');
       }
       $db_req->execute();
       $result = $db_req->fetchAll();

       if( $db_req->rowCount() > 0)
       {
          if($password == $result[0]['mdp'])
          {
            if ($category == 'etudiant')
             header('Location: index.php?action=interface-etudiant');
            else if ($category == 'enseignant')
              header('Location: index.php?action=interface-enseignant');
          }
          else
          {
             echo "Mauvais mot de passe.";
             return false;
          }
       }
       else {
         echo "Vous avez entré un login ou numéro étudiant érroné.";
         return false;
       }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
  }
}

function sign_in()
{
  require('../Views/LoginView.php');
}

function interface_etudiant()
{
  require('../Views/InterfaceEtudiantView.php');
}

function interface_enseignant()
{
  require('../Views/InterfaceEnseignantView.php');
}

function is_logged_in()
{
  return true;
}
