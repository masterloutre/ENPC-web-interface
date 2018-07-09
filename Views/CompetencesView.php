
<section class="competences">
  <h3>Résumé des compétences</h3>
  <div class="flex-container">

  <?php for ($i=0; $i < count($competences_tab); $i++) { ?> 

    <article class="competence">
    <h4><?php echo( $competences_tab[$i]->get_nom() ); ?></h4>
    <div class="results">
    <div class="points points-totaux">
      <p class="points-obtenu">
        <?php echo( $content['score_competence'.($i+1)]->get_points() ); ?>
      </p>
      <p class="points-max">
        /
        <?php echo( $content['points_max_competence'.($i+1)] ); ?>
      </p>
    </div>

    <div class="situation-pro-container">

    <?php for ($j=0; $j < count($situation_pro_tab); $j++) { ?>

      <div class="situation-pro">
        <div class="points">
          <p class="points-obtenu">
            <?php echo( $content['score_situation_pro'.($j+1)]->get_points() ); ?>
          </p>
          <p class="points-max">
            /
            <?php echo( $content['points_max_situation_pro'.($j+1)] ); ?>
          </p>
        </div>
        <p class="intitule">
          <?php echo( $situation_pro_tab[$j]->get_nom() ); ?>
        </p>
      </div>

    <?php } ?>

    </div>
  </article>
  <?php } ?>

  

</div>
</section>
