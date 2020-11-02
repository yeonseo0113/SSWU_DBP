<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> THE WORLD </title>
</head>
<body>
    <h1><p style="text-align:center">THE WORLD</p></h1>
    <hr color="black">
    <form action="world_select.php" method="POST">
        <h3><p style="text-align:center">나라 정보 조회
        <input type="text" name="starts_with" placeholder="starts_with">
        <input type="submit" value="Search">
        </p>
        </h3>
    </form>
    <form action="country_select.php" method="POST">
        <h3><p style="text-align:center">나라 검색
        <input type="text" name="country" placeholder="country">
        <input type="submit" value="Search">
        </p>
        </h3>
    </form>
   <form action="continent_select.php" method="POST">
       <h3><p style="text-align:center">대륙별 나라 조회
       <select name="continent">
           <option value="Asia">Asia</option>
           <option value="Europe">Europe</option>
           <option value="Africa">Africa</option>
           <option value="Oceania">Oceania</option>
           <option value="North America">North America</option>
           <option value="South America">South America</option>
           <input type="submit" value="Search">
       </select>
       </p>
       </h3>
    </form>
    <form action="update.php" method="POST">
        <h3><p style="text-align:center">나라 정보 수정
        <input type="text" name="country" placeholder="country">
        <input type="submit" value="Search">
        </p>
        </h3>
    </form>
    <form action="avg.php" method="POST">
        <h3><p style="text-align:center">평균 비교
        <input type="text" name="country" placeholder="country">
        <input type="submit" value="Search">
        </p>
        </h3>
    </form>
</body>
</html>
