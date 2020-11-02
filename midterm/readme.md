💻 개발 환경 소개
- 어떤 데이터베이스를 사용하였나? MySQL
```
MySQL은 이미 여러 분야에 적용되어 제품의 안정성이 검증된 가장 인기 있는 오픈 소스 관계형 데이터베이스 시스템으로,
ANSI/ISO표준에서 정의한 데이터베이스 접속을 위한 가장 일반적인 표준 언어인 SQL을 사용하기 때문에 배우고 사용하기 쉬우며,
SQL 표준함수의 경우 타 DB와 동일하게 사용이 가능하다. 또한, LAMP(Linux, Apache, MySQL,PHP/Perl)는 물론 SAMP(Solaris, Apache, MySQL, PHP/Perl),
WAMP (Windows, Apache, MySQL,PHP/Perl) 등 사용자의 환경에 맞는 대부분의 플랫폼을 지원함은 물론 MySQL 데이터베이스 소프트웨어는
다중-쓰레드SQL서버로 클라이언트/서버 또는 임베디드 시스템에서 사용할 수 있다.
스토리지 엔진은 동적으로 변경하여 관리할 수 있으며 사용하는 어플리케이션의 최적의 성능을 나타낼 수 있도록 도와준다.
```

- 어떤 웹 서버를 사용하였나? 윈도우 + Apache Web Server
```
운영체제 시장에서 윈도우의 점유율은 91.07%에 이를 정도로 널리 사용되고 있고, 대부분 윈도우 기반에서 홈페이지를 열람하기 때문에
윈도우 내장폰트에 의존하는 웹페이지들의 텍스트 서식을 보기 위해 윈도우에 apm을 설치하여 사용하였다.
```

😮❗️ 발견한 정보 소개
- json_extract(): json 데이터를 string으로 반환, $는 doc.의 root를 의미하며 깊이를 표현하여 원하는 데이터를 추출할 수 있다.
- json_unquote(): string으로 반환된 데이터의 ""를 제거하여 반환
- json_set(): json 데이터 내용 set

- 전 세계의 나라 정보 조회하기
```
// $filtered_id로 받아온 글자로 시작하는 나라들 출력
// 나라 이름, 수도, GNP, 수장, 정부 형태, 인구 수, 기대 수명, 인구 밀도와 같은 기본적인 정보 출력

// 사용자가 소문자로 검색하여도 제대로 출력할 수 있게 ucfirst()를 이용해 대문자로 변환하여 저장
$filtered_id = ucfirst(mysqli_real_escape_string($link, $_POST['country']));
$query = "SELECT country.Name as Country, city.Name as Capital, json_unquote(json_extract(doc,'$.GNP')) as GNP,
                 json_unquote(json_extract(doc,'$.government.HeadOfState')) as Head,
                 json_unquote(json_extract(doc,'$.government.GovernmentForm')) as GovernmentForm,
                 json_unquote(json_extract(doc,'$.demographics.Population')) as Population,
                 json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy,
                 json_unquote(json_extract(doc,'$.demographics.Population'))/json_unquote(json_extract(doc,'$.geography.SurfaceArea')) as Population_Density
          FROM country join city on country.Capital = city.ID
          join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
          WHERE LEFT(SUBSTRING_INDEX(replace(country.Name,' ',''), ' ', -1), 1) = '{$filtered_id}' limit 5 ";
```

- 특정 나라를 검색하여 정보 조회하기
```
// 사용자가 소문자로 검색하여도 제대로 출력할 수 있게 ucfirst()를 이용해 대문자로 변환하여 저장
$filtered_id = ucfirst(mysqli_real_escape_string($link, $_POST['country']));

$query = "SELECT country.Name as Country, city.Name as Capital, json_unquote(json_extract(doc,'$.GNP')) as GNP,
          json_unquote(json_extract(doc,'$.government.HeadOfState')) as Head,
          json_unquote(json_extract(doc,'$.government.GovernmentForm')) as GovernmentForm,
          json_unquote(json_extract(doc,'$.demographics.Population')) as Population,
          json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy,
          json_unquote(json_extract(doc,'$.demographics.Population'))/json_unquote(json_extract(doc,'$.geography.SurfaceArea')) as Population_Density
          FROM country join city on country.Capital = city.ID
          join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
          // 입력받은 나라
          WHERE country.Name = '{$filtered_id}'";
```

- 대륙별 나라 조회
```
// 셀렉트 박스형태에서 원하는 대륙 선택
<select name="continent">
    <option value="Asia">Asia</option>
    <option value="Europe">Europe</option>
    <option value="Africa">Africa</option>
    <option value="Oceania">Oceania</option>
    <option value="North America">North America</option>
    <option value="South America">South America</option>
    <input type="submit" value="Search">
</select>

$query = "SELECT country.name as Country, json_unquote(json_extract(doc,'$.geography.Region')) as Region
          FROM country join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
          WHERE json_unquote(json_extract(doc,'$.geography.Continent')) = '{$filtered_id}' limit 5";
```

- 나라 정보 수정
```
// 현시점과 맞지 않는 정보는 새로 입력한 내용({$filtered['column']})으로 수정 후 수정된 결과를 출력
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
```

- 평균 비교
```
// 전 세계 평균 기대수명과 인구 수를 원하는 나라와 비교
$query = "SELECT avg(json_extract(doc,'$.demographics.LifeExpectancy')) as avg_LifeExpectancy,
                 avg(json_extract(doc,'$.demographics.Population')) as avg_Population
          From countryinfo";
$query2 = "SELECT country.Name as Country, json_unquote(json_extract(doc,'$.demographics.LifeExpectancy')) as LifeExpectancy,
                  json_unquote(json_extract(doc,'$.demographics.Population')) as Population
           FROM country join countryinfo on country.name = json_unquote(json_extract(doc,'$.Name'))
           WHERE country.Name = '{$filtered_id}'";
```
📼 동작 영상
<https://drive.google.com/drive/folders/1wIdvNANDJQQeb9sqv27sPT3ghRjR2l0g?usp=sharing>
1. k로 시작하는 나라들 정보 출력
2. 특정 나라(south korea)에 대한 정보 출력
3. south korea의 head 수정 후 수정 결과(김대중 -> 문재인) 출력
4. 대륙별 나라 조회 -> 아프리카 대륙의 나라들 출력
5. south korea와 전세계 평균 기대수명, 인구 수 비교
