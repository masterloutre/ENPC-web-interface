<?php

echo '<h3>requête de test de LDAP</h3>';
echo 'Connexion ...';
$ldap_host = 'ldap://172.21.0.94/';
//$ldap_dn = "dc=enpc-test,dc=fr";
$ds = ldap_connect($ldap_host)  // doit être un serveur LDAP valide !
or die("Impossible de se connecter au serveur LDAP {$ldap_host}");

echo 'Le résultat de connexion est ' . $ds . '<br />';

  echo 'Liaison ...';
  $r=@ldap_bind($ds, $ldap_dn);     // connexion anonyme, typique
                                   // pour un accès en lecture seule.

  if ($r)
  {
    echo 'Le résultat de connexion est ' . $r . '<br />';

    echo 'Recherchons (sn=S*) ...';
    // Recherche par nom
    $sr=ldap_search($ds,"o=My Company, c=US", "sn=S*");
    echo 'Le résultat de la recherche est ' . $sr . '<br />';

    echo 'Le nombre d\'entrées retournées est ' . ldap_count_entries($ds,$sr)
         . '<br />';

    echo 'Lecture des entrées ...<br />';
    $info = ldap_get_entries($ds, $sr);
    echo 'Données pour ' . $info["count"] . ' entrées:<br />';

    for ($i=0; $i<$info["count"]; $i++) {
        echo 'dn est : ' . $info[$i]["dn"] . '<br />';
        echo 'premiere entree cn : ' . $info[$i]["cn"][0] . '<br />';
        echo 'premier email : ' . $info[$i]["mail"][0] . '<br />';
    }

    echo 'Fermeture de la connexion';
    ldap_close($ds);
  }
  else {
    echo '<h4>Impossible de se connecter au serveur LDAP.</h4>';
}
