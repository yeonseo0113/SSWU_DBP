<?php
  $link = mysqli_connect('localhost', 'root', 'rootroot', 'world_x');
  $filtered_id = ucfirst(mysqli_real_escape_string($link, $_POST['country']));
  $query = "SELECT avg(json_extract(doc,'$.demographics.LifeExpectancy')) as avg_LifeExpectancy,
                   avg(json_extract(doc,'$.demographics.Population')) as avg_Population
            From countryinfo";
  $query2 = "SELECT country.Name as Country, json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy,
                    json_unquote(json_extract(doc,'$.demographics.Population')) as Population
             FROM country join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
             WHERE country.Name = '{$filtered_id}'";

  $result = mysqli_query($link, $query);
  $result2 = mysqli_query($link, $query2);

  $world_info = '';
  while($row = mysqli_fetch_array($result2)) {
    $world_info .= '<tr>';
    $world_info .= '<td>'.$row['Country'].'</td>';
    $world_info .= '<td>'.$row['LifeExpectancy'].'</td>';
    $world_info .= '<td>'.$row['Population'].'</td>';
  }
  while($row = mysqli_fetch_array($result)) {
    $world_info .= '<td>'.$row['avg_LifeExpectancy'].'</td>';
    $world_info .= '<td>'.$row['avg_Population'].'</td>';
    $world_info .= '</tr>';
  }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>나라 정보 조회</title>
    <style>
        table.co {
        border-collapse: separate;
        border-spacing: 1px;
        text-align: center;
        line-height: 1;
        margin: 20px 10px;
    }
    table.co th {
        padding: 10px;
        font-weight: bold;
        vertical-align: top;
        color: #fff;
        background: #8cbded ;
    }
    table.co td {
        padding: 10px;
        vertical-align: top;
        border-bottom: 1px solid #ccc;
        background: #eee;
    }
</style>
</head>
<body>
    <h2><a href="index.php"><img src="https://image.freepik.com/free-vector/pixel-cartoon-earth_41992-768.jpg"
    alt="THE WORLD" width="80" height="80" align="center" border="0"/></a>평균 비교</h2>
    <table class = "co" border="1">
        <tr>
            <th>Country</th>
            <th>LifeExpectancy</th>
            <th>Population</th>
            <th>avg_LifeExpectancy</th>
            <th>avg_Population</th>
        </tr>
        <?= $world_info ?>
    </table>
</body>

</html>
