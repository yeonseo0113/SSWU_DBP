<?php
    $link = mysqli_connect('localhost', 'root', 'rootroot', 'dbp');

    $query = "SELECT * FROM color_code";
    $result = mysqli_query($link, $query);
    $author_info = '';
    while($row = mysqli_fetch_array($result)){
        $filtered = array(
            'id' => htmlspecialchars($row['id']),
            'code' => htmlspecialchars($row['code']),
            'RGB' => htmlspecialchars($row['RGB'])
        );
        $author_info .= '<tr>';
        $author_info .= '<td>'.$filtered['id'].'</td>';
        $author_info .= '<td>'.$filtered['code'].'</td>';
        $author_info .= '<td>'.$filtered['RGB'].'</td>';
        $author_info .= '<td><a href="color_code.php?id='.$filtered['id'].'">update</a></td>';
        $author_info .= '<td>
            <form action="process_delete_color_code.php" method="post">
                <input type="hidden" name="id" value="'.$filtered['id'].'">
                <input type="submit" value="delete">
            </form></td>
        ';
        $author_info .= '</tr>';
    };

    $escaped = array(
        'code' => '',
        'RGB' => ''
    );

    $label_submit = 'Create ColorCode';
    $form_action = 'process_create_color_code.php';
    $form_id = '';

    if(isset($_GET['id'])) {
        $filtered_id = mysqli_real_escape_string($link, $_GET['id']);
        settype($filtered_id, 'integer');
        $query = "SELECT * FROM color_code WHERE id = {$filtered_id}";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        $escaped['code'] = htmlspecialchars($row['code']);
        $escaped['RGB'] = htmlspecialchars($row['RGB']);
        $label_submit = 'Update ColorCode';
        $form_action = 'process_update_color_code.php';
        $form_id = '<input type="hidden" name="id" value="'.$_GET['id'].'">';
    };
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My Color</title>
    </head>
    <body>
        <h1><a href="index.php">My Color</a></h1>
        <p><a href="index.php">color</a></p>
        <table border="1">
            <tr>
                <th>id</th>
                <th>code</th>
                <th>RGB</th>
                <th>update</th>
                <th>delete</th>
            </tr>
            <?= $author_info ?>
        </table>
        <br>
        <form action="<?=$form_action?>" method="post">
            <?=$form_id?>
            <label for="fname">code:</label><br>
            <input type="text" id="code" name="code" placeholder="code" value="<?=$escaped['code']?>"><br>
            <label for="lname">RGB:</label><br>
            <input type="text" id="RGB" name="RGB" placeholder="RGB" value="<?=$escaped['RGB']?>"><br><br>
            <input type="submit" value="<?=$label_submit?>">
        </form>
    </body>
</html>
