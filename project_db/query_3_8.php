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
        <h2>Βρείτε τους ερευνητές που εργάζονται σε 5 ή περισσότερα έργα που δεν έχουν παραδοτέα.</h2>
        <table class="table">
            <thead>
                <tr>
                  <th> Όνομα </th>
                  <th> Επίθετο </th>
                  <th> Πλήθος Έργων </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                $sql = "CREATE OR REPLACE TEMPORARY TABLE temp
                      	SELECT id FROM active_projects
                      	WHERE id NOT IN (
                                    SELECT ap.id FROM
                      	            active_projects ap INNER JOIN report
                      	            ON ap.id = report.project_id
                                    GROUP BY ap.id
                                    		);";
                $connection->query($sql);
                $sql = "SELECT first_name, last_name, COUNT(*) no_projects FROM
                        researcher_project rp
                        WHERE rp.id IN (SELECT * FROM temp)
                        GROUP BY rp.res_id HAVING no_projects>=5 ORDER BY no_projects;";
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
