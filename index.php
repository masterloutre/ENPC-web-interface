<?php
require_once './Controllers/FrontEndController.php';
require_once './Controllers/SessionController.php';
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
    else if ($_GET['action'] == 'interface-enseignant-competence') {
        if (enseignant_logged_in()) { interface_enseignant_competence(); }
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
    else if ($_GET['action'] == 'interface-admin') {
      if (admin_logged_in()) { interface_admin(); }
      else {
        forbidden_access();
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
