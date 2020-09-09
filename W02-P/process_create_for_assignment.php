<?php
  $link = mysqli_connect("localhost", "root", "rootroot", "dbp");
  $query = "
    INSERT INTO w02_assignment
      (title, description, created)
      VALUES (
        '{$_POST['title']}',
        '{$_POST['description']}',
        now()
        )
  ";
  $result = mysqli_query($link, $query);
  if($result == false){
    echo '저장하는 과정에서 문제가 발생했습니다. 관라자에게 문의하세요.';
    error_log(mysqli_error($link));
  } else {
    echo '성공했습니다. <a href="index_for_assignment.php">돌아가기</a>';  
  }
?>
