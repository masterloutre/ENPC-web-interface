<?php

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Etudiant.php";
require_once "../Models/Enseignant.php";

function login()
{
  include "../Global/connect.php";

  if (isset($_POST["mdp"]) && isset($_POST["login"]))
  {
    $login = $_POST["login"];
    $password = $_POST["mdp"];
    try
    {
       $db_req = $db->prepare(
         'SELECT *
          FROM enseignant
          WHERE enseignant.login = "'.$login.'"
          LIMIT 1');
       $db_req->execute();
       $result = $db_req->fetchAll();

       if ($db_req->rowCount() == 0)
       {
         $db_req = $db->prepare(
           'SELECT *
            FROM etudiant
            WHERE etudiant.num_etud = "'.$login.'"
            LIMIT 1');
         $db_req->execute();
         $result = $db_req->fetchAll();
       }

       if( $db_req->rowCount() > 0)
       {
          if(sha1('gz'.$password) == $result[0]['mdp'])
          {
               $_SESSION['user_session'] = $result[0]['token'];
            if (isset($result[0]['num_etud'])) // Etudiant
            {
              $_SESSION['login'] = array('login' => utf8_encode($result[0]['num_etud']));
              header('Location: index.php?action=interface-etudiant');
            }
            else if (isset($result[0]['login']))
            {
              $_SESSION['login'] = array('login' => utf8_encode($result[0]['login']));
              if (true == $result[0]['admin'])
                header('Location: index.php?action=interface-admin');
              else
              header('Location: index.php?action=interface-enseignant');
            }
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

function logout() {
  $_SESSION = array();
  session_destroy();
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

function interface_admin()
{
  require('../Views/InterfaceAdminView.php');
}

function forbidden_access()
{
  require('../Views/ForbiddenAccessView.php');
}
