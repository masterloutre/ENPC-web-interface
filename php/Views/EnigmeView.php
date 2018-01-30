<br><br><br>
<article class="enigme">
  <div class="points-totaux">
    <h3><?php echo( $enigme['nom'] ); ?></h3>
    <p class="points-obtenu">
      <?php echo ( $enigme['points'] ); ?>
    </p>
    <p class="points-max">
      / <?php echo( $enigme['points_max'] ); ?>
    </p>
  </div>
  <h4 class="competence">
    <?php echo ($enigme['competence']); ?>
  </h4>
  <div class="situation_pro_bar">
    <?php
    for ($y = 0; $y < count($enigme['situations_pro']); ++$y)
    {
      echo ($enigme['situations_pro'][$y]->get_nom().' '.$enigme['situations_pro'][$y]->get_ratio().'%' );
    }
    ?>
  </div>
  <div class="temps">
    <?php echo ($enigme['temps']); ?>
    <?php echo (' / '.$enigme['temps_max']); ?>
  </div>
  <div class="aide">
    <?php if ($enigme['aide'] != false)
    {
      echo "Aide";
    }
    ?>
  </div>
  <div class="tentatives">
    <?php echo ($enigme['tentatives']); ?>
  </div>
</article>
