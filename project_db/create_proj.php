<?php
include 'db_connect.php';

$id = "";
$title = "";
$summary = "";
$start_date = "";
$end_date = "";
$evaluator_id = "";
$evaluator_grade = "";
$evaluation_date = "";
$supervisor_id = "";
$controller_id = "";
$sponsor_id = "";
$sponsor_amount = "";
$managing_org_id = "";
$managing_date = "";
$field_name = [];

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $title = $_POST["title"];
    $summary = $_POST["summary"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $evaluator_id = $_POST["evaluator_id"];
    $evaluator_grade = $_POST["evaluator_grade"];
    $evaluation_date = $_POST["evaluation_date"];
    $supervisor_id = $_POST["supervisor_id"];
    $controller_id = $_POST["controller_id"];
    $sponsor_id = $_POST["sponsor_id"];
    $sponsor_amount = $_POST["sponsor_amount"];
    $managing_org_id = $_POST["managing_org_id"];
    $managing_date = $_POST["managing_date"];
    if (isset($_POST["field_name"])) {
        $field_name = $_POST["field_name"];
    }

    do {
        if ( empty($title) || empty($summary) || empty($start_date) || empty($end_date) || empty($evaluator_id)
            || empty($evaluator_grade) || empty($evaluation_date) || empty($supervisor_id)
            || empty($controller_id) || empty($sponsor_id) || empty($sponsor_amount) || empty($managing_org_id)
            || empty($managing_date) || empty($field_name)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // add new client to database
        $sql =  "INSERT INTO project (title, summary, start_date, end_date, evaluator_id, evaluator_grade,
                evaluation_date, supervisor_id, controller_id, sponsor_id, sponsor_amount, managing_org_id, managing_date ) " .
                "VALUES ('$title', '$summary', '$start_date', '$end_date', '$evaluator_id', '$evaluator_grade', " .
                "'$evaluation_date', '$supervisor_id', '$controller_id', '$sponsor_id', '$sponsor_amount', '$managing_org_id', '$managing_date')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $sql = "SELECT id FROM project ORDER BY id DESC LIMIT 1";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $id = $row['id'];

        foreach ($field_name as $item) {
            $sql = "INSERT INTO field VALUES ('$id', '$item')";
            $result = $connection->query($sql);
            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
                break;
            }
        }

        $id = "";
        $title = "";
        $summary = "";
        $start_date = "";
        $end_date = "";
        $evaluator_id = "";
        $evaluator_grade = "";
        $evaluation_date = "";
        $supervisor_id = "";
        $controller_id = "";
        $sponsor_id = "";
        $sponsor_amount = "";
        $managing_org_id = "";
        $managing_date = "";
        $field_name = [];


        $successMessage = "project added correctly";

        header("location: /project_db/project_list.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Εισαγωγή νέου έργου</h2>

        <?php
        if ( !empty($errorMessage) ) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post" id="curr">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Τίτλος</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Περίληψη</label>
                <div class="col-sm-6">
                    <textarea form="curr" class="form-control" name="summary" value="<?php echo $summary; ?>"><?php echo $summary; ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ημερομηνία Έναρξης</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ημερομηνία Λήξης</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Δείκτης/ID Αξιολογητή</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="evaluator_id" value="<?php echo $evaluator_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Βαθμός Αξιολόγησης</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="evaluator_grade" value="<?php echo $evaluator_grade; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ημερομηνία Αξιολόγησης</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="evaluation_date" value="<?php echo $evaluation_date; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Δείκτης/ID Επιστημονικού Υπεύθυνου</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="supervisor_id" value="<?php echo $supervisor_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Δείκτης/ID Στελέχους διαχείρισης</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="controller_id" value="<?php echo $controller_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Δείκτης/ID Προγράμματος Επιχορήγησης</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="sponsor_id" value="<?php echo $sponsor_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ποσό Επιχορήγησης</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="sponsor_amount" value="<?php echo $sponsor_amount; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Δείκτης/ID Οργανισμού Διαχείρισης</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="managing_org_id" value="<?php echo $managing_org_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ημερομηνία Έναρξης Διαχείρισης</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="managing_date" value="<?php echo $managing_date; ?>">
                </div>
            </div>
            <fieldset class="border p-2">
                <legend class="w-auto">Επιστημονικά Πεδία</legend>
                <br>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ' <?php if(in_array("ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ", $field_name)) echo "checked" ?>>
                <label for='ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ'>Φυσικές Επιστήμες</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΤΕΧΝΟΛΟΓΙΑ' <?php if(in_array("ΤΕΧΝΟΛΟΓΙΑ", $field_name)) echo "checked" ?>>
                <label for='ΤΕΧΝΟΛΟΓΙΑ'>Τεχνολογία</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΙΑΤΡΙΚΗ' <?php if(in_array("ΙΑΤΡΙΚΗ", $field_name)) echo "checked" ?>>
                <label for='ΙΑΤΡΙΚΗ'>Ιατρική</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΓΕΩΠΟΝΙΚΗ' <?php if(in_array("ΓΕΩΠΟΝΙΚΗ", $field_name)) echo "checked" ?>>
                <label for='ΓΕΩΠΟΝΙΚΗ'>Γεωπονική</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΠΛΗΡΟΦΟΡΙΚΗ' <?php if(in_array("ΠΛΗΡΟΦΟΡΙΚΗ", $field_name)) echo "checked" ?>>
                <label for='ΠΛΗΡΟΦΟΡΙΚΗ'>Πληροφορική</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ' <?php if(in_array("ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ", $field_name)) echo "checked" ?>>
                <label for='ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ'>Κοινωνικές Επιστήμες</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΤΕΧΝΕΣ' <?php if(in_array("ΤΕΧΝΕΣ", $field_name)) echo "checked" ?>>
                <label for='ΤΕΧΝΕΣ'>Τέχνες</label>
                </div>
                <div>
                <input type="checkbox" id="field_name[]" name="field_name[]" value='ΟΙΚΟΝΟΜΙΚΑ' <?php if(in_array("ΟΙΚΟΝΟΜΙΚΑ", $field_name)) echo "checked" ?>>
                <label for='ΟΙΚΟΝΟΜΙΚΑ'>Οικονομικά</label>
                </div>
            </fieldset>

            <?php
            if ( !empty($successMessage) ) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/project_db/project_list.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
