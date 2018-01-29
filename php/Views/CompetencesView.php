<section>
  <article class="competence1">
    <div class="points-totaux">
      <p class="points-obtenu">
        <?php echo( $content['score_competence1']->get_points() ); ?>
      </p>
      <p class="points-max">
        / <?php echo( $content['points_max_competence1'] ); ?>
      </p>
    </div>
    <div class="situation-pro-container">

      <div class="situation_pro">
        <p class="points-obtenu">
          <?php echo( $content['score_situation_pro1']->get_points() ); ?>
        </p>
        <p class="points-max">
          / <?php echo( $content['points_max_situation_pro1'] ); ?>
        </p>
        <p class="intitule">
          <?php echo( $situation_pro1->get_nom() ); ?>
        </p>
      </div>

      <div class="situation_pro">
        <p class="points-obtenu">
          <?php echo( $content['score_situation_pro2']->get_points() ); ?>
        </p>
        <p class="points-max">
          / <?php echo( $content['points_max_situation_pro2'] ); ?>
        </p>
        <p class="intitule">
          <?php echo( $situation_pro2->get_nom() ); ?>
        </p>
      </div>

      <div class="situation_pro">
        <p class="points-obtenu">
          <?php echo( $content['score_situation_pro3']->get_points() ); ?>
        </p>
        <p class="points-max">
          / <?php echo( $content['points_max_situation_pro3'] ); ?>
        </p>
        <p class="intitule">
          <?php echo( $situation_pro3->get_nom() ); ?>
        </p>
      </div>

    </div>
  </article>

  <article class="competence2">
    <div class="points-totaux">
      <p class="points-obtenu">
        <?php echo( $content['score_competence2']->get_points() ); ?>
      </p>
      <p class="points-max">
        / <?php echo( $content['points_max_competence2'] ); ?>
      </p>
    </div>
    <div class="situation-pro-container">

      <div class="situation_pro">
        <p class="points-obtenu">
          <?php echo( $content['score_situation_pro4']->get_points() ); ?>
        </p>
        <p class="points-max">
          / <?php echo( $content['points_max_situation_pro4'] ); ?>
        </p>
        <p class="intitule">
          <?php echo( $situation_pro4->get_nom() ); ?>
        </p>
      </div>

      <div class="situation_pro">
        <p class="points-obtenu">
          <?php echo( $content['score_situation_pro5']->get_points() ); ?>
        </p>
        <p class="points-max">
          / <?php echo( $content['points_max_situation_pro5'] ); ?>
        </p>
        <p class="intitule">
          <?php echo( $situation_pro5->get_nom() ); ?>
        </p>
      </div>

      <div class="situation_pro">
        <p class="points-obtenu">
          <?php echo( $content['score_situation_pro6']->get_points() ); ?>
        </p>
        <p class="points-max">
          / <?php echo( $content['points_max_situation_pro6'] ); ?>
        </p>
        <p class="intitule">
          <?php echo( $situation_pro6->get_nom() ); ?>
        </p>
      </div>

    </div>
  </article>
</section>
