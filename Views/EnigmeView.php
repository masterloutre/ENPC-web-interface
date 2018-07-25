<br><br><br>
<article class="enigme">
  <h4><?php echo( $enigme['nom'] ); ?></h4>
  <div class="flex-container">
    <div class="points-totaux">
      <p class="points-obtenu">
        <?php echo ( $enigme['points']*$enigme['difficulte'] ); ?>
      </p>
      <p class="points-max">
        /
        <?php echo( $enigme['points_max']*$enigme['difficulte'] ); ?>
      </p>
    </div>
    <h5 class="competence-title">
    <?php echo ($enigme['competence']); ?>
  </h5>
    <div class="temps">
      <?php echo ($enigme['temps']); ?>
      <?php echo ('<span class="low-opacity"> / '.$enigme['temps_max'].' min</span>'); ?>
    </div>
    <div class="aide">
      <?php if ($enigme['aide'] != false)
    {
      echo "Aide";
    }
    ?>
    </div>
    <div class="difficulte">
      <?php
      echo '<p>Difficulté ('.$enigme['difficulte'].')</p>';
      for ($a = 0; $a < $enigme['difficulte']; ++$a)
      {
        echo '<div class="tentative-full-box"></div>';
      }
      ?>
    </div>
  </div>
  <div class="situation_pro_bar">
   <div class="flex-container">
      <?php
      for ($y = 0; $y < count($enigme['situations_pro']); ++$y)
      {
        echo '<span data-size="'.$enigme['situations_pro'][$y]->get_ratio().
                  '" style="flex-grow :'.$enigme['situations_pro'][$y]->get_ratio().
                  '; height : 10px; background-color : '.$enigme['situations_pro'][$y]->get_couleur().
        ';"></span>';
      }?>
    </div>
  <?php
  for ($y = 0; $y < count($enigme['situations_pro']); ++$y)
  {
    echo '<div class="tentative-full-box" style="background-color:'.$enigme['situations_pro'][$y]->get_couleur().';"></div>'.$enigme['situations_pro'][$y]->get_nom().' | ';
  }
  ?>
  </div>
</article>
