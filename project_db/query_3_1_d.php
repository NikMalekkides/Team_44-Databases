<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program</title>
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
        <h2>Έργα τα οποία χειρίζεται το στέλεχος με ID = <?php echo $_GET['id_3_1_d']; ?> </h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Τίτλος </th>
                    <th> Περίληψη </th>
                    <th> Ημερομηνία Έναρξης </th>
                    <th> Ημερομηνία Λήξης </th>
                    <th> ID Αξιολογητή </th>
                    <th> Βαθμός Αξιολόγησης </th>
                    <th> Ημερομηνία Αξιολόγησης </th>
                    <th> ID Επιστημονικού Υπεύθυνου </th>
                    <th> ID Στελέχους Διαχείρησης </th>
                    <th> ID Χορηγού </th>
                    <th> Επιχορήγηση </th>
                    <th> ID Οργανισμού Διαχείρησης </th>
                    <th> Ημερομηνία Αναλαβής </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                // read all row from database table
                $sql = "SELECT * FROM project
                        WHERE controller_id = " . $_GET['id_3_1_d'];
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td> $row[id] </td>
                        <td> $row[title] </td>
                        <td> $row[summary] </td>
                        <td> $row[start_date] </td>
                        <td> $row[end_date] </td>
                        <td> $row[evaluator_id] </td>
                        <td> $row[evaluator_grade] </td>
                        <td> $row[evaluation_date] </td>
                        <td> $row[supervisor_id] </td>
                        <td> $row[controller_id] </td>
                        <td> $row[sponsor_id] </td>
                        <td> $row[sponsor_amount] </td>
                        <td> $row[managing_org_id] </td>
                        <td> $row[managing_date] </td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
