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
        <h2>Βρείτε τα top-5 στελέχη που δουλεύουν για το ΕΛ.ΙΔ.Ε.Κ. και έχουν δώσει το μεγαλύτερο ποσό χρηματοδοτήσεων σε μια εταιρεία.</h2>
        <table class="table">
            <thead>
                <tr>
                  <th> Όνομα </th>
                  <th> Επίθετο </th>
                  <th> Όνομα Εταιρείας </th>
                  <th> Συνολικό Ποσό </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                $sql = "SELECT first_name, last_name, org_name, SUM(sponsor_amount) total FROM
                        employee INNER JOIN (
                                  SELECT * FROM project_organisation
                                  WHERE category = 'Company'
                                            ) AS temp
                        ON employee.id = temp.controller_id
                        GROUP BY employee.id, temp.org_id
                        ORDER BY total DESC LIMIT 5;";
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
                        <td> $row[org_name] </td>
                        <td> $row[total] </td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
