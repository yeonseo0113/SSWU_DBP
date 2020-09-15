<?php
  $link = mysqli_connect("localhost","root","rootroot","dbp");
  $query = "
    INSER INTO w02_assignment (
      title,
      description,
      created
    ) VALUES (
      'MySQL',
      'MySQL is ...',
      now()
    )";

  $result = mysqli_query($link, $query);

    if($result == false){
      echo mysqli_error($link);
    }
?>
