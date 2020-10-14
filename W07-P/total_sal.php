<?php
    $link = mysqli_connect('localhost', 'admin', 'admin', 'employees');

    if(mysqli_connect_errno()){
        echo "Failed to connect to MariaDB: " . mysqli_connect_error();
        exit();
    }    

    settype($_GET['number'], 'integer');
    $filtered_number = mysqli_real_escape_string($link, $_GET['number']);
    
    $query = "
        SELECT salaries.emp_no,employees.first_name,salary,from_date,to_date, case when to_date = '9999-01-01' then TIMESTAMPDIFF(year,from_date,'2020-10-15')*salary 
                                                                                                           else TIMESTAMPDIFF(year,from_date,to_date)*salary end as TOTAL   
        FROM salaries
        INNER JOIN employees
        ON salaries.emp_no = employees.emp_no        
        ORDER BY salary DESC
        LIMIT ".$filtered_number."
    ";

    $result = mysqli_query($link, $query);  
    
    $article = '';    
    while($row = mysqli_fetch_array($result)){
        $article .= '<tr><td>';
        $article .= $row["emp_no"];
        $article .= '</td><td>';
        $article .= $row["first_name"];
        $article .= '</td><td>';
        $article .= $row["salary"];
        $article .= '</td><td>';
        $article .= $row["from_date"];
        $article .= '</td><td>';
        $article .= $row["to_date"];
        $article .= '</td><td>';
        $article .= $row["TOTAL"];
        $article .= '</td></tr>';
    }
    
    mysqli_free_result($result);
    mysqli_close($link);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>연봉 정보</title>
    <style>
        body {
            font-family: Consolas, monospace;
            font-family: 12px;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #dadada;
        }
    </style> 
</head>

<body>
    <h2><a href="index.php">직원 관리 시스템</a> | 연봉 정보</h2>
    <table>
        <tr>
            <th>emp_no</th>
            <th>first_name</th>
            <th>salary</th>
            <th>from_date</th>
            <th>to_date</th>
            <th>TOTAL</th>
        </tr>        
        <?= $article ?>
    </table>
</body>

</html>