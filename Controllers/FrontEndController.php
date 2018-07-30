<?php

require "./Global/connect.php";
require "./Global/global.php";
require_once "./Models/Etudiant.php";
require_once "./Models/Enseignant.php";
require_once "./Controllers/SessionController.php";
require_once "./Controllers/ScoreController.php";
require_once "./Controllers/EtudiantController.php";
require_once "./Controllers/EnigmeController.php";

function login()
{
  include "./Global/connect.php";

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
              header('Location: index.php?action=interface-enseignant-competence');
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
  require('./Views/HeaderConnection.php');
  require('./Views/LoginView.php');
}

function sign_in()
{
  require('./Views/HeaderConnection.php');
  require('./Views/LoginView.php');
}

function interface_etudiant()
{
  include "./Global/connect.php";
  include "./Global/global.php";
  $etudiant = who_is_logged_in();
  $enigmes = get_all_enigme_from_etudiant($db, $etudiant);
  $enigmes_tab = [];


  for ($i = 0; $i < count($enigmes); ++$i)
  {
    $array = [
      'nom' => $enigmes[$i]->get_nom(),
      'points' => get_score_from_etudiant_on_enigme($db, $etudiant, $enigmes[$i])->get_points(),
      'points_max' => $enigmes[$i]->get_score_max(),
      'difficulte' => $enigmes[$i]->get_difficulte(),
      'competence' => get_competence_from_enigme($db, $enigmes[$i])->get_nom(),
      'situations_pro' => get_situation_pro_from_enigme($db, $enigmes[$i]),
      'temps' => get_score_from_etudiant_on_enigme($db, $etudiant, $enigmes[$i])->get_temps(),
      'temps_max' => $enigmes[$i]->get_temps_max(),
      'aide' => get_score_from_etudiant_on_enigme($db, $etudiant, $enigmes[$i])->get_aide(),
      'tentatives' => get_score_from_etudiant_on_enigme($db, $etudiant, $enigmes[$i])->get_tentatives(),
      'tentatives_max' => $enigmes[$i]->get_tentatives_max()
    ];
    $enigmes_tab[] = $array;
  }
  
  $content = [ 
      'title' => 'Interface Etudiant',
      'user' => who_is_logged_in(),
      'category' => 'Etudiant',
      'enigmes' => $enigmes_tab
  ];
  
  for ($i = 0 ; $i < count($competences_tab) ; $i++)
  {
    $content['score_competence'.($i+1) ]= get_score_from_etudiant_on_competence($db, $etudiant, $competences_tab[$i]);
    $content['points_max_competence'.($i+1) ] = get_score_max_from_competence_by_etudiant($db, $competences_tab[$i], $etudiant);
  }
  for ($i = 0 ; $i < count($situation_pro_tab) ; $i++)
  {
    $content['score_situation_pro'.($i+1) ]= get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro_tab[$i]);
    $content['points_max_situation_pro'.($i+1) ] = get_score_max_from_situation_pro_by_etudiant($db, $situation_pro_tab[$i], $etudiant);
  }
  require('./Views/HeaderView.php');
  require('./Views/CompetencesView.php');
  require('./Views/EnigmesView.php');
  echo '<script src="./Public/js/ratio_situ_pro.js"></script>';
}


function interface_enseignant_competence()
{
  include "./Global/connect.php";
  include "./Global/global.php";

  $etudiants = get_all_etudiant($db);
  $etudiants_tab = [];
  for ($i = 0; $i < count($etudiants); ++$i)
  {
    $array = [
      'nom' => $etudiants[$i]->get_nom(),
      'prenom' => $etudiants[$i]->get_prenom()
    ];
    for ($j = 0 ; $j < count($competences_tab) ; $j++)
    {
      $array['competence'.($j+1) ]= get_score_from_etudiant_on_competence($db, $etudiants[$i], $competences_tab[$j])->get_points();
    }
    for ($j = 0 ; $j < count($situation_pro_tab) ; $j++)
    {
      $array['situation_pro'.($j+1) ]= get_score_from_etudiant_on_situation_pro($db, $etudiants[$i], $situation_pro_tab[$j])->get_points();
    }
    $etudiants_tab[] = $array;
  }

  $content = [ 'title' => 'Interface Enseignant',
  'user' => who_is_logged_in(),
  'category' => 'Enseignant',
     'etudiants' => $etudiants_tab
  ];
  for ($i = 0 ; $i < count($competences_tab) ; $i++)
  {
    $content['score_competence'.($i+1) ]= get_moyenne_score_from_competence($db, $competences_tab[$i]);
    $content['points_max_competence'.($i+1) ] = get_score_max_from_competence($db, $competences_tab[$i]);
  }
  for ($i = 0 ; $i < count($situation_pro_tab) ; $i++)
  {
    $content['score_situation_pro'.($i+1) ]= get_moyenne_score_from_situation_pro($db, $situation_pro_tab[$i]);
    $content['points_max_situation_pro'.($i+1) ] = get_score_max_from_situation_pro($db, $situation_pro_tab[$i]);
  }
  
  require('./Views/HeaderView.php');
  if($content['user']->get_admin()){
    require('./Views/AdminReturnView.php');
  }
  require('./Views/EnseignantMenuView.php');
  require('./Views/CompetencesView.php');
  require('./Views/EtudiantsTabView.php');
}

function interface_enseignant_enigme()
{
  include "./Global/connect.php";
  include "./Global/global.php";

  $enigmes = get_all_enigme($db);
  $enigmes_tab = [];

  for ($i = 0; $i < count($enigmes); ++$i)
  {
    $array = [
      'nom' => $enigmes[$i]->get_nom(),
      'points' => get_moyenne_score_from_enigme($db, $enigmes[$i])->get_points(),
      'points_max' => $enigmes[$i]->get_score_max(),
      'difficulte' => $enigmes[$i]->get_difficulte(),
      'competence' => get_competence_from_enigme($db, $enigmes[$i])->get_nom(),
      'situations_pro' => get_situation_pro_from_enigme($db, $enigmes[$i]),
      'temps' => get_moyenne_score_from_enigme($db, $enigmes[$i])->get_temps(),
      'temps_max' => $enigmes[$i]->get_temps_max(),
      'aide' => get_moyenne_score_from_enigme($db, $enigmes[$i])->get_aide(),
      'tentatives' => get_moyenne_score_from_enigme($db, $enigmes[$i])->get_tentatives(),
      'tentatives_max' => $enigmes[$i]->get_tentatives_max()
    ];
    $enigmes_tab[] = $array;
  }
  $content = [ 'title' => 'Interface Enseignant', 'user' => who_is_logged_in(), 'category' => 'Enseignant',
              'enigmes' => $enigmes_tab
            ];
  require('./Views/HeaderView.php');
  if($content['user']->get_admin()){
    require('./Views/AdminReturnView.php');
  }
  require('./Views/EnseignantMenuView.php');
  require('./Views/EnigmesView.php');
  echo '<script src="./Public/js/ratio_situ_pro.js"></script>';
}

function interface_admin()
{
  $content = [ 'title' => 'Interface Administrateur', 'user' => who_is_logged_in(), 'category' => 'Administrateur'];
  require('./Views/HeaderView.php');
  require('./Views/AdminReturnView.php');
    if(array_key_exists('vue', $_GET)){
        require('./Views/'.$_GET['vue'].'Admin.php');
    }else{
        require('./Views/homeAdmin.php');
    }
  echo '<script src="./Public/js/ratio_situ_pro.js"></script>';
}

function forbidden_access()
{
  require('./Views/ForbiddenAccessView.php');
}

function admin_add()
{
  require('./Views/add.php');
}

function admin_delete()
{
  require('./Views/delete.php');
}

function admin_update()
{
  require('./Views/update.php');
}

function admin_multiple_update()
{
  require('./Views/multipleUpdate.php');
}
