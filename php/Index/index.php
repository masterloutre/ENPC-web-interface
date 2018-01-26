<?php
require('../Controllers/FrontEndController.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        login();
    }
    else if ($_GET['action'] == 'interface-etudiant') {
        interface_etudiant();
    }
    else if ($_GET['action'] == 'interface-enseignant') {
        interface_enseignant();
    }
    else if ($_GET['action'] == 'interface-admin') {
        interface_admin();
    }
}
else
{
  sign_in();
}
