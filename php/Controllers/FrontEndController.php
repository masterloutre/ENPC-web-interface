<?php

require "../Global/connect.php";
require "../Global/global.php";
require_once "../Models/Etudiant.php";
require_once "../Models/Enseignant.php";
require_once "../Controllers/SessionController.php";
require_once "../Controllers/ScoreController.php";

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
  require('../Views/LoginView.php');
}

function sign_in()
{
  require('../Views/LoginView.php');
}

function interface_etudiant()
{
  include "../Global/connect.php";
  include "../Global/global.php";
  $etudiant = who_is_logged_in();
  $content = [ 'title' => 'Interface Etudiant', 'user' => who_is_logged_in(), 'category' => 'Etudiant',

               'score_competence1' => get_score_from_etudiant_on_competence($db, $etudiant, $competence1),
               'points_max_competence1' => get_score_max_from_competence($db, $competence1, $etudiant),
                   'score_competence2' => get_score_from_etudiant_on_competence($db, $etudiant, $competence2),
                   'points_max_competence2' => get_score_max_from_competence($db, $competence2, $etudiant),
               'score_situation_pro1' => get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro1),
               'points_max_situation_pro1'=> get_score_max_from_situation_pro($db, $situation_pro1, $etudiant),
                   'score_situation_pro2' => get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro2),
                   'points_max_situation_pro2'=> get_score_max_from_situation_pro($db, $situation_pro2, $etudiant),
               'score_situation_pro3' => get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro3),
               'points_max_situation_pro3'=> get_score_max_from_situation_pro($db, $situation_pro3, $etudiant),
                   'score_situation_pro4' => get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro4),
                   'points_max_situation_pro4'=> get_score_max_from_situation_pro($db, $situation_pro4, $etudiant),
               'score_situation_pro5' => get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro5),
               'points_max_situation_pro5'=> get_score_max_from_situation_pro($db, $situation_pro5, $etudiant),
                   'score_situation_pro6' => get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro6),
                   'points_max_situation_pro6'=> get_score_max_from_situation_pro($db, $situation_pro6, $etudiant)
            ];
  require('../Views/HeaderView.php');
  require('../Views/InterfaceEtudiantView.php');
  require('../Views/CompetencesView.php');
}

function interface_enseignant()
{
  $content = [ 'title' => 'Interface Enseignant', 'user' => who_is_logged_in(), 'category' => 'Enseignant'];
  require('../Views/HeaderView.php');
  require('../Views/InterfaceEnseignantView.php');
}

function interface_admin()
{
  $content = [ 'title' => 'Interface Administrateur', 'user' => who_is_logged_in(), 'category' => 'Administrateur'];
  require('../Views/HeaderView.php');
  require('../Views/InterfaceAdminView.php');
    if(array_key_exists('vue', $_GET)){
        require('../Views/'.$_GET['vue'].'Admin.php');
    }else{
        require('../Views/homeAdmin.php');
    }
}

function forbidden_access()
{
  require('../Views/ForbiddenAccessView.php');
}
