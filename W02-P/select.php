<?php
  $link = mysqli_connect('localhost', 'root', 'rootroot', 'dbp');
  $query = "SELECT * FROM w02_assignment";
  $result = mysqli_query($link, $query);

  // print_r(mysqli_fetch_array($result)); // 한 번 실행할 때마다 하나씩 알려줌 -> mysql 출력함
  while ($row = mysqli_fetch_array($result)) {
    echo '<h2>'.$row['title'].'</h2>';
    echo $row['description'];
  }
 ?>
