<?php
  $link = mysqli_connect('localhost','root','rootroot','dbp');
  $query = "SELECT * FROM w02_assignment";
  $result = mysqli_query($link, $query);
  $list ='';
  while ($row = mysqli_fetch_array($result)) {
    $escaped_title = htmlspecialchars($row['title']);
    $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$escaped_title}</a></li>";
  }

  $article = array(
    'title' => 'Welcome',
    'description' => 'Color is ...'
  );

  $update_link = '';
  $delete_link = '';
  $code = '';  // 여기

  if( isset($_GET['id'])) {
    $filtered_id = mysqli_real_escape_string($link, $_GET['id']);
    //$query = "SELECT * FROM topic LEFT JOIN author ON topic.author_id = author.id WHERE topic.id={$filtered_id}";
    $query = "SELECT * FROM w02_assignment Left Join color_code on w02_assignment.code_id = color_code.id
                WHERE w02_assignment.id = {$filtered_id}";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    $article['title'] = htmlspecialchars($row['title']);
    $article['description'] = htmlspecialchars($row['description']);
    $article['code'] = htmlspecialchars($row['code']);

    $update_link = '<a href="update.php?id='.$_GET['id'].'">update</a>';
    $delete_link = '
      <form action="process_delete.php" method="post">
        <input type="hidden" name="id" value="'.$_GET['id'].'">
        <input type="submit" value="delete">
      </form>
    ';
    $code = "<p> {$article['code']}</p>";
  }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My Color</title>
  </head>
  <body>
    <h1><a href="index.php">My Color</a></h1>
    <a href="color_code.php">ColorCode</a>
    <ol><?= $list ?></ol>
    <a href="create.php">create</a>
    <?= $update_link ?>
    <?= $delete_link ?>
    <h2><?= $article['title'] ?></h2>
    <?= $article['description'] ?>
    <?= $code ?>
  </body>
</html>
