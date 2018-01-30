
<section class="enigme">
  <h3>Résultats par énigme</h3>
    <?php
    for ($x = 0; $x < count($content['enigmes']); ++$x)
    {
      $enigme = $content['enigmes'][$x];
      require "../Views/EnigmeView.php";
    }
    ?>
</section>
