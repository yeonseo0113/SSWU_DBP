<?php
    $link = mysqli_connect('localhost', 'root', 'rootroot', 'dbp');

    $filtered = array(
        'title' => mysqli_real_escape_string($link, $_POST['title']),
        'description' => mysqli_real_escape_string($link, $_POST['description']),
        'code_id' => mysqli_real_escape_string($link, $_POST['code_id'])
    );
    $query = "
        INSERT INTO w02_assignment
            (title, description, created, code_id)
            VALUES(
                '{$filtered['title']}',
                '{$filtered['description']}',
                NOW(),
                '{$filtered['code_id']}'
            )
    ";

    $result = mysqli_multi_query($link, $query);
    if( $result == false ){
        echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($link));
    } else {
        echo '성공했습니다. <a href="index.php">돌아가기</a>';
    }
?>
