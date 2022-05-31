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
        <h2>Βρείτε τους ερευνητές, ηλικίας < 40 ετών, που εργάζονται στα περισσότερα ενεργά έργα και τον αριθμό των έργων που εργάζονται.</h2>
        <table class="table">
            <thead>
                <tr>
                  <th> Όνομα </th>
                  <th> Επίθετο </th>
                  <th> Πλήθος </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                $sql = "CREATE OR REPLACE TEMPORARY TABLE temp
                        SELECT first_name, last_name, COUNT(*) no_projects  FROM
                        active_projects ac INNER JOIN researcher_project rp
                        ON ac.id = rp.id
                        WHERE rp.date_of_birth>DATE_ADD(CURRENT_DATE(), INTERVAL -40 YEAR)
                        GROUP BY rp.id ORDER BY no_projects;";
                $connection->query($sql);
                $sql = "SELECT * FROM temp
                        WHERE no_projects = (SELECT MAX(no_projects) FROM temp);";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td> $row[first_name] </td>
                        <td> $row[last_name] </td>
                        <td> $row[no_projects] </td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
