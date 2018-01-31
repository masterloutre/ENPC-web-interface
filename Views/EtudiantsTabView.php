<section class="tab-etudiants">
<h3>Détail par étudiant</h3>
<table>
  <tr>
    <th>Etudiant</th>
    <th>Compétence 1 - <?php echo $competence1->get_nom(); ?></th>
    <th><?php echo $situation_pro1->get_nom(); ?></th>
    <th><?php echo $situation_pro2->get_nom(); ?></th>
    <th><?php echo $situation_pro3->get_nom(); ?></th>
    <th>Compétence 2 - <?php echo $competence2->get_nom(); ?></th>
    <th><?php echo $situation_pro4->get_nom(); ?></th>
    <th><?php echo $situation_pro5->get_nom(); ?></th>
    <th><?php echo $situation_pro6->get_nom(); ?></th>
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
