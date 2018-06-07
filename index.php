<?php
require_once './Controllers/FrontEndController.php';
require_once './Controllers/SessionController.php';
require_once './Controllers/GameInterfaceController.php';

start();
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        login();
    }
    else if ($_GET['action'] == 'interface-etudiant') {
        if (etudiant_logged_in()) { interface_etudiant(); }
        else {
          forbidden_access();
        }
    }
    else if ($_GET['action'] == 'interface-enseignant-enigme') {
        if (enseignant_logged_in()) { interface_enseignant_enigme(); }
        else {
          forbidden_access();
        }
    }
    else if ($_GET['action'] == 'interface-enseignant-competence') {
        if (enseignant_logged_in()) { interface_enseignant_competence(); }
        else {
          forbidden_access();
        }
    }
    else if ($_GET['action'] == 'interface-admin') {
      if (admin_logged_in()) {
        if (isset($_GET['admin']) && $_GET['admin'] == 'add')
        {
          admin_add();
        }
        else if (isset($_GET['admin']) && $_GET['admin'] == 'delete')
        {
          admin_delete();
        }
        else if (isset($_GET['admin']) && $_GET['admin'] == 'update')
        {
          admin_update();
        }
        else
        {
          interface_admin();
        }
      }
      else {
        forbidden_access();
      }
    }

    else if ($_GET['action'] == 'who-is-player'){
        if(etudiant_logged_in()) {
           send_player_info(who_is_logged_in());
           //
        } else {
            //echo "no one is logged in";
            //header("HTTP/1.1 404 Not Found");
            //return null;
        }
    }

    else if ($_GET['action'] == 'logout') {
      logout();
    }
}
else
{
  sign_in();
}
