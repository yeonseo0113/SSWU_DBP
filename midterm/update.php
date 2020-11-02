<?php
    $link = mysqli_connect('localhost', 'root', 'rootroot', 'world_x');
    $filtered_id = ucfirst(mysqli_real_escape_string($link, $_POST['country']));
    $query = "SELECT country.Name as Country, city.Name as Capital, json_unquote(json_extract(doc,'$.GNP')) as GNP,
              json_unquote(json_extract(doc,'$.government.HeadOfState')) as Head,
              json_unquote(json_extract(doc,'$.government.GovernmentForm')) as GovernmentForm,
              json_unquote(json_extract(doc,'$.demographics.Population')) as Population,
              json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy
              FROM country JOIN city ON country.Capital = city.ID
              JOIN countryinfo ON country.name = json_unquote(json_extract(doc,'$.Name'))
              WHERE country.Name = '{$filtered_id}'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>THE WORLD</title>
</head>
<body>
    <h2><a href="index.php"><img src="https://image.freepik.com/free-vector/pixel-cartoon-earth_41992-768.jpg"
    alt="THE WORLD" width="80" height="80" align="center" border="0"/></a>나라 정보 수정</h2>
    <form action="update_process.php" method="POST">
        <label>Country</label>
        <input type="text" name="Country" value="<?=$row['Country']?>" placeholder="Country"><br>
        <label>Capital</label>
        <input type="text" name="Capital" value="<?=$row['Capital']?>" placeholder="Capital"><br>
        <label>GNP</label>
        <input type="text" name="GNP" value="<?=$row['GNP']?>" placeholder="GNP"><br>
        <label>Head</label>
        <input type="text" name="Head" value="<?=$row['Head']?>" placeholder="Head"><br>
        <label>GovernmentForm</label>
        <input type="text" name="GovernmentForm" value="<?=$row['GovernmentForm']?>" placeholder="GovernmentForm"><br>
        <label>Population</label>
        <input type="text" name="Population" value="<?=$row['Population']?>" placeholder="Population"><br>
        <label>LifeExpectancy</label>
        <input type="text" name="LifeExpectancy" value="<?=$row['LifeExpectancy']?>" placeholder="LifeExpectancy"><br>
        <input type="submit" value="Update">
    </form>
</body>
