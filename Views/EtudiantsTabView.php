<section class="tab-etudiants">
<h3>Détail par étudiant</h3>
<table>
  <tr>
    <th>Etudiant</th>
    <?php for ($i=0; $i < count($competences_tab); $i++) { ?>

      <th>Compétence <?php $i+1 ?> - <?php echo $competences_tab[$i]->get_nom(); ?></th>

      

    <?php } ?>

    <?php for ($j=0; $j < count($situation_pro_tab); $j++) { ?>

        <th><?php echo $situation_pro_tab[$j]->get_nom(); ?></th>

      <?php } ?>
      
  </tr>
  <?php
  for ($x =0; $x < count($content['etudiants']); ++$x)
  {
    $etudiant = $content['etudiants'][$x];
    require "./Views/EtudiantTabLineView.php";
  }
  ?>
</table>
</section>
