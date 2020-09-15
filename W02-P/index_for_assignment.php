<?php
  $link = mysqli_connect('localhost','root','rootroot','dbp');
  $query = "SELECT * FROM w02_assignment";
  $result = mysqli_query($link, $query);
  $list ='';
  while ($row = mysqli_fetch_array($result)) {
    $list = $list."<li><a href=\"index_for_assignment.php?id={$row['id']}\">{$row['title']}</a></li>";
  }

  $article = array(
  'title' => 'Welcome',
  'description' => 'COLOR is ...'
  );

  if( isset($_GET['id'])) {
    $query = "SELECT * FROM w02_assignment WHERE id={$_GET['id']}"; 
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    $article = array(
      'title' => $row['title'],
      'description' => $row['description']
    );
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>COLOR</title>
  </head>
  <body>
    <h1><a href="index_for_assignment.php">COLOR</a></h1>
    <ol><?= $list ?></ol>
    <a href="create_for_assignment.php">create</a>
    <h2><?= $article['title'] ?></h2>
    <?= $article['description'] ?>
  </body>
</html>
