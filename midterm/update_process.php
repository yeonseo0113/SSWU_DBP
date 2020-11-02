<?php
$link = mysqli_connect('localhost', 'root', 'rootroot', 'world_x');
$filtered = array(
    'Country' => ucfirst(mysqli_real_escape_string($link, $_POST['Country'])),
    'Capital' => ucfirst(mysqli_real_escape_string($link, $_POST['Capital'])),
    'GNP' => mysqli_real_escape_string($link, $_POST['GNP']),
    'Head' => ucfirst(mysqli_real_escape_string($link, $_POST['Head'])),
    'GovernmentForm' => ucfirst(mysqli_real_escape_string($link, $_POST['GovernmentForm'])),
    'Population' => mysqli_real_escape_string($link, $_POST['Population']),
    'LifeExpectancy' => mysqli_real_escape_string($link, $_POST['LifeExpectancy'])
);
$query = "
        UPDATE countryinfo
        SET doc = json_set(doc,'$.Name','{$filtered['Country']}'),
                  doc = json_set(doc,'$.GNP','{$filtered['GNP']}'),
                  doc = json_set(doc,'$.government.HeadOfState','{$filtered['Head']}'),
                  doc = json_set(doc,'$.government.GovernmentForm','{$filtered['GovernmentForm']}'),
                  doc = json_set(doc,'$.demographics.Population','{$filtered['Population']}'),
                  doc = json_set(doc,'$.demographics.LifeExpectancy','{$filtered['LifeExpectancy']}')
        WHERE
            json_unquote(json_extract(doc,'$.Name')) = '{$filtered['Country']}'
        ";
$result = mysqli_query($link, $query);
$world_info = '';

if ($result == false) {
    echo '수정하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.';
    error_log(mysqli_error($link));
  }
else {
  $query = "select country.Name as Country, city.Name as Capital, json_unquote(json_extract(doc,'$.GNP')) as GNP,
            json_unquote(json_extract(doc,'$.government.HeadOfState')) as Head,
            json_unquote(json_extract(doc,'$.government.GovernmentForm')) as GovernmentForm,
            json_unquote(json_extract(doc,'$.demographics.Population')) as Population,
            json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy
            from country join city on country.Capital = city.ID
            join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
            where country.Name = '{$filtered['Country']}'";
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
    $world_info .= '</tr>';
  }
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
    alt="THE WORLD" width="80" height="80" align="center" border="0"/></a>정보 수정 결과</h2>
    <table class = "co" border="1">
        <tr>
            <th>Country</th>
            <th>Capital</th>
            <th>GNP</th>
            <th>Head</th>
            <th>GovernmentForm</th>
            <th>Population</th>
            <th>LifeExpectancy</th>
        </tr>
        <?= $world_info ?>
    </table>
</body>

</html>
