<!-- Ceci affiche le nom d'une compétence, son score,
et les situations professionnelles associées, pour chaque objet compétence du tableau
-->
<section class="competences">
  <h3>Résumé des Compétences</h3>
  <div class="flex-container">

  <?php for ($i=0; $i < count($competences_tab); $i++) { 
    $competence=$competences_tab[$i];
    $indice=$i;
    if($content['points_max_competence'.($indice+1)]->get_points() != 0 && $content['points_max_competence'.($indice+1)]->get_points() != -1 ){
      require('./Views/CompetenceView.php');
    }
  }
  ?> 


  

</div>
</section>
