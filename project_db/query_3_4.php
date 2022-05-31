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
        <h2>Ποιοι οργανισμοί έχουν λάβει τον ίδιο αριθμό έργων σε διάστημα δύο συνεχόμενων ετών, με τουλάχιστον 10 έργα ετησίως. </h2>
        <table class="table">
            <thead>
                <tr>
                  <th>ID Οργανισμού 1</th>
                  <th>ID Οργανισμού 2</th>
                  <th>Πρώτο Έτος</th>
                  <th>Δεύτερο Έτος</th>
                  <th>Συνολικό Πλήθος Έργων</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                // read all row from database table
                $sql = "CREATE OR REPLACE TEMPORARY TABLE temp
                      	SELECT org_id , YEAR(managing_date) m_year, COUNT(*) no_projects
                      	FROM project_organisation
                      	GROUP BY org_id, m_year
                      	HAVING no_projects>=10;";
                $connection->query($sql);
                $sql = "CREATE OR REPLACE TEMPORARY TABLE temp2
                      	SELECT t1.org_id, t1.m_year year1, t1.no_projects year1_count, t2.m_year year2, t2.no_projects year2_count
                        FROM temp t1 INNER JOIN temp t2
                        ON t1.org_id = t2.org_id AND t1.m_year = t2.m_year-1;";
                $connection->query($sql);
                $sql = "SELECT t1.org_id id1, t2.org_id id2, t1.year1, t1.year2, t1.year1_count + t1.year2_count total
                      	FROM temp2 t1 INNER JOIN temp2 t2
                      	ON t1.year1 = t2.year1
                      	WHERE t1.org_id<t2.org_id AND t1.year1_count+t1.year2_count = t2.year1_count+t2.year2_count;";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[id1]</td>
                        <td>$row[id2]</td>
                        <td>$row[year1]</td>
                        <td>$row[year2]</td>
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
