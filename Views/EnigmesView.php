<!-- Ceci affiche un cadre contenant les informations sur une énigme en moyenne (pour un enseignant) ou indivduelle (pour un étudiant).
Il comporte notamment le nom de l'énigme, le nom d'une compétence, son score,
et les situations professionnelles associées.
-->
<section class="enigme">
  <h3>Résultats par énigme</h3>
    <?php
    for ($x = 0; $x < count($content['enigmes']); ++$x)
    {
      $enigme = $content['enigmes'][$x];
      require "./Views/EnigmeView.php";
    }
    ?>
</section>
