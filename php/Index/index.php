<?php
require('../Controllers/FrontEndController.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        login();
    }
}
else
{
  sign_in();
}
