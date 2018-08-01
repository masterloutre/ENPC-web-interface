<article class="competence">
    <h4><?php echo( $competence->get_nom() ); ?></h4>
    <div class="results">
    <div class="points points-totaux">
      <p class="points-obtenu">
        <?php echo( $content['score_competence'.($indice+1)]->get_points() );?>
      </p>
      <p class="points-max">
        /
        <?php echo( $content['points_max_competence'.($indice+1)]->get_points() ); ?>
      </p>
    </div>

    <div class="situation-pro-container">

    <?php for ($j=0; $j < count($situation_pro_tab); $j++) { 
      if($content['points_max_situation_pro'.($j+1)][$indice]->get_points() != 0 && $content['points_max_situation_pro'.($j+1)][$indice]->get_points() != -1){
    ?>

      <div class="situation-pro">
        <div class="points">
          <p class="points-obtenu">
            <?php echo( $content['score_situation_pro'.($j+1)][$indice]->get_points() ); ?>
          </p>
          <p class="points-max">
            /
            <?php echo( $content['points_max_situation_pro'.($j+1)][$indice]->get_points() ); ?>
          </p>
        </div>
        <p class="intitule">
          <?php echo( $situation_pro_tab[$j]->get_nom() ); ?>
        </p>
      </div>

    <?php }
    } ?>

    </div>
  </article>