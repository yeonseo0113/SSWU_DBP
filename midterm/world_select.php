<?php
  $link = mysqli_connect('localhost', 'root', 'rootroot', 'world_x');
  $filtered_id = ucfirst(mysqli_real_escape_string($link, $_POST['starts_with']));
  $query = "SELECT country.Name as Country, city.Name as Capital, json_unquote(json_extract(doc,'$.GNP')) as GNP,
                   json_unquote(json_extract(doc,'$.government.HeadOfState')) as Head,
                   json_unquote(json_extract(doc,'$.government.GovernmentForm')) as GovernmentForm,
                   json_unquote(json_extract(doc,'$.demographics.Population')) as Population,
                   json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy,
                   json_unquote(json_extract(doc,'$.demographics.Population'))/json_unquote(json_extract(doc,'$.geography.SurfaceArea')) as Population_Density
            FROM country join city on country.Capital = city.ID
            join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
            WHERE LEFT(SUBSTRING_INDEX(replace(country.Name,' ',''), ' ', -1), 1) = '{$filtered_id}' limit 5 ";

  $result = mysqli_query($link, $query);
  $world_info = '';
  while($row = mysqli_fetch_array($result)) {
    $world_info .= '<tr>';
    $world_info .= '<td>'.$row['Country'].'</td>';
    $world_info .= '<td>'.$row['Capital'].'</td>';
    $world_info .= '<td>'.$row['GNP'].'</td>';
    $world_info .= '<td>'.$row['Head'].'</td>';
    $world_info .= '<td>'.$row['GovernmentForm'].'</td>';
    $world_info .= '<td>'.$row['Population'].'</td>';
    $world_info .= '<td>'.$row['LifeExpectancy'].'</td>';
    $world_info .= '<td>'.$row['Population_Density'].'</td>';
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
        vertical-align: center;
        color: #fff;
        background: #8cbded ;
    }
    table.co td {
        padding: 10px;
        vertical-align: center;
        border-bottom: 1px solid #ccc;
        background: #eee;
    }
</style>
</head>

<body>
    <h2><a href="index.php"><img src="https://image.freepik.com/free-vector/pixel-cartoon-earth_41992-768.jpg"
      alt="THE WORLD" width="80" height="80" align="center" border="0"/></a>나라 정보 조회</h2>
    <table class = "co" border="1">
        <tr>
            <th>Country</th>
            <th>Capital</th>
            <th>GNP</th>
            <th>Head</th>
            <th>GovernmentForm</th>
            <th>Population</th>
            <th>LifeExpectancy</th>
            <th>Population_Density</th>
        </tr>
        <?= $world_info ?>
    </table>
</body>

</html>
