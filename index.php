<?php
$host = 'localhost';
$dbname = 'world';
$user = 'root';
$password = '';
$population = 7000000;

try {
    $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dsn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $stmt = $dsn->query('SELECT * FROM  city WHERE POPULATION > 8000000');
    $stmt1 = $dsn->query('SELECT * FROM  city WHERE POPULATION > 8000000');
    // $stmt2 = $dsn-> query('SELECT * FROM  city WHERE POPULATION > ?');


} catch (PDOException $e) {
    echo "Connection Failed: " . '<br>' . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        tr:nth-child(odd) {
            background-color: #454545;
            color: white;
        }

        th {
            background-color: white;
            color: black;

        }

        table {
            width: 99%;
            margin: 0 auto;
        }

        table,
        th,
        tr,
        td {
            border: 2px solid black;
            border-collapse: collapse;
        }
    </style>
    <title>PDO</title>
    <h1>Cities With Population Less than 8 Million</h1>
    <h2>Array PDO</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Population</th>
        </tr>
        <tr>
            <?php while ($row = $stmt->fetch()) {
                echo '<tr><td>' . $row['Name'] . '</td><td>' . $row['District'] . '</td><td>' . $row['Population'] . '</td></tr>';;
            } ?>
        </tr>

    </table>
    <h2>Object PDO</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Population</th>
        </tr>
        <tr>
            <?php while ($row = $stmt1->fetch(PDO::FETCH_OBJ)) {
                echo '<tr><td>' . $row->Name . '</td><td>' . $row->District . '</td><td>' . $row->Population . '</td></tr>';;
            } ?>
        </tr>

    </table>
    <h2>Prepared Statements</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Population</th>
        </tr>
        <tr>
            <?php
            $sql = "SELECT * FROM  city WHERE POPULATION > ?";
            $stmt2 = $dsn->prepare($sql);
            $stmt2->execute([$population]);
            $posts = $stmt2->fetchAll();

            foreach ($posts as $post) {
                echo '<tr><td>' . $post['Name'] . '</td><td>' . $post['District'] . '</td><td>' . $post['Population'] . '</td></tr>';
            }
            ?>
        </tr>

    </table>
    <h2>Named Params</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Population</th>
        </tr>
        <tr>
            <?php
            $sql = 'SELECT * FROM  city WHERE POPULATION > :population';
            $stmt2 = $dsn->prepare($sql);
            $stmt2->execute(['population' => $population]);
            $posts = $stmt2->fetchAll();

            foreach ($posts as $post) {
                echo '<tr><td>' . $post['Name'] . '</td><td>' . $post['District'] . '</td><td>' . $post['Population'] . '</td></tr>';
            }
            ?>
        </tr>

    </table>
    <h2>Named Params</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Population</th>
        </tr>
        <tr>
            <?php
            $id = 2;
            $sql = 'SELECT * FROM  city WHERE ID =:id';
            $stmt3 = $dsn->prepare($sql);
            $stmt3->execute(['id' => $id]);
            $posts = $stmt2->fetch();


            echo '<tr><td>' . $post['Name'] . '</td><td>' . $post['District'] . '</td><td>' . $post['Population'] . '</td></tr>';


            ?>
        </tr>

    </table>
    <h3>Get Row Count</h3>
    <?php $stmt4 = $dsn->prepare('SELECT * FROM city WHERE Population > ?');
    $stmt4->execute([$population]);
    $citycount = $stmt4->rowCount();
    echo " There are {$citycount} Rows that have a population of {$population} or more!";
    ?>
</head>

<body>

</body>

</html>