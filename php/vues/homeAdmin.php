<!DOCTYPE html>
<html>
   <head>
       <title>Interface Admin</title>
       <link rel="stylesheet" href="../../css/font-awesome.css">
       <style>
           body{
               text-transform: capitalize;
               font-family: sans-serif;
           }
           table, th, td{
               border: 1px solid black;
               border-collapse: collapse;
               padding: 15px 30px;
           }
           a{
               text-decoration: none;
               color: black;
           }
           a:visited{
               color: black;
           }
           .button{
               margin: 20px 0;
               border: 1px solid black;
               padding: 5px 10px;
               display: inline-block;
           }
           .wrapper{
               margin: 0 auto;
               width: max-content;
           }
       </style>
   </head>
   
    <body>
      <div class="wrapper">
         <h2>Gestion des données</h2>
          <a class="button" href="listeAdmin.php?item=enigme">Accéder aux énigmes</a>
          <a class="button" href="listeAdmin.php?item=etudiant">Accéder aux étudiants</a>
          <a class="button" href="listeAdmin.php?item=enseignant">Accéder aux enseignants</a>
          <a class="button" href="listeAdmin.php?item=situation_pro">Accéder aux Situation professionnelles</a>
          <a class="button" href="listeAdmin.php?item=lancement_jeu">Accéder aux phases de jeu</a>
      </div>
    </body>
    
</html>