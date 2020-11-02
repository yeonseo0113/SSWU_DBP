<?php
  $link = mysqli_connect('localhost', 'root', 'rootroot', 'world_x');
  $filtered_id = ucfirst(mysqli_real_escape_string($link, $_POST['continent']));
  $query = "SELECT country.name as Country, json_unquote(json_extract(doc,'$.geography.Region')) as Region
            FROM country join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
            WHERE json_unquote(json_extract(doc,'$.geography.Continent')) = '{$filtered_id}' limit 5";

  $result = mysqli_query($link, $query);
  $world_info = '';

  while($row = mysqli_fetch_array($result)) {
    $world_info .= '<tr>';
    $world_info .= '<td>'.$row['Country'].'</td>';
    $world_info .= '<td>'.$row['Region'].'</td>';
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
    alt="THE WORLD" width="80" height="80" align="center" border="0"/></a>대륙별 나라 조회</h2>
    <table class = "co" border="1">
        <tr>
            <th>Country</th>
            <th>Region</th>
        </tr>
        <?= $world_info ?>
    </table>
</body>

</html>
