<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $content['title']; ?></title>
  <link rel="stylesheet" href="./Public/css/font-awesome.css">
  <link rel="stylesheet" href="./Public/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>
<body>

<header>
  <h1><?php echo ($content['user']->get_prenom()." <span class='upper'>".$content['user']->get_nom()); ?></span></h1>
  <h2><?php echo $content['category']; ?></h2>
  <a href="index.php?action=logout"><p>Déconnexion</p></a>
</header>
