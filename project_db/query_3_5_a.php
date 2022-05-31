<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a id="navbar-items" href="/project_db/index.php/">
                <i class="fa fa-home "></i> Homepage
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <h2>Ανάμεσα σε ζεύγη πεδίων που είναι κοινά στα έργα, βρείτε τα 3 κορυφαία ζεύγη που εμφανίστηκαν σε έργα (με κριτήριο το συνολικό ποσό επιχορήγησης).</h2>
        <table class="table">
            <thead>
                <tr>
                  <th>Πεδίο 1</th>
                  <th>Πεδίο 2</th>
                  <th>Συνολικό Ποσό</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                // read all row from database table
                $sql = "CREATE TEMPORARY TABLE field_pairs
                          SELECT f1.field_name field1, f2.field_name field2, f1.project_id id FROM
                          field f1 INNER JOIN field f2 ON f1.project_id = f2.project_id
                          WHERE f1.field_name < f2.field_name;";
                $connection->query($sql);
                $sql = "SELECT field1, field2, SUM(project.sponsor_amount) total FROM
                        field_pairs INNER JOIN project on field_pairs.id = project.id
                        GROUP BY field1, field2 ORDER BY total DESC LIMIT 3;";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[field1]</td>
                        <td>$row[field2]</td>
                        <td>$row[total]</td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
