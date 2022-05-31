<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        Project UI
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

</head>


<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a class="navbar-brand" id="nav-bar-text">Project UI - Team 44 - Homepage</a>
            <a id="navbar-items" href="/project_db/index.php/">
                <i class="fa fa-home "></i> Refresh
            </a>
        </div>
    </nav>

    <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Οργανισμοί</h4>
                        <p class="card-text" id="paragraph">Λίστα με οργανισμούς.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/org_list.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Έργα</h4>
                        <p class="card-text" id="paragraph">Λίστα με έργα.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/project_list.php">Show</a>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ενεργά Έργα</h4>
                        <p class="card-text" id="paragraph">Λίστα με ενεργά έργα.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/active_project_list.php">Show</a>
                    </div>
                </div>
            </div>
            -->
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερευνητές</h4>
                        <p class="card-text" id="paragraph">Λίστα με ερευνητές.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/res_list.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" id="row-2">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.1 (Α)</h4>
                        <p class="card-text" id="paragraph">Όλα τα προγράμματα που είναι διαθέσιμα.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_1_a.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.1 (B)</h4>
                        <p class="card-text" id="paragraph">Ερευνητές που εργάζονται σε δοσμένο έργο (δώσε ID έργου).</p>
                        <form action="/project_db/query_3_1_b.php" method="get">
                            <input type="int" name="id_3_1_b" required>
                            <a href="/project_db/query_3_1_b.php">
                                <input type="submit" required>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.1 (C)</h4>
                        <p class="card-text" id="paragraph">Έργα τα οποία θα είναι ενεργά σε δοσμένη ημερομηνία (είσοδος απο χρήστη).</p>
                        <form action="/project_db/query_3_1_c.php" method="get">
                            <input type="date" name="date_3_1_c" required>
                            <a href="/project_db/query_3_1_c.php">
                                <input type="submit" required>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" id="row-3">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.1 (D)</h4>
                        <p class="card-text" id="paragraph">Έργα τα οποία χειρίζεται δοσμένο στέλεχος (δώσε ID στελέχους).</p>
                        <form action="/project_db/query_3_1_d.php" method="get">
                            <input type="int" name="id_3_1_d" required>
                            <a href="/project_db/query_3_1_d.php">
                                <input type="submit" required>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.1 (E)</h4>
                        <p class="card-text" id="paragraph">Έργα με διάρκεια μικρότερη απο δοσμένο όριο. (δώσε διάρκεια σε έτη).</p>
                        <form action="/project_db/query_3_1_e.php" method="get">
                            <input type="text" name="id_3_1_e" required>
                            <a href="/project_db/query_3_1_e.php">
                                <input type="submit" required>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.2 (Α)</h4>
                        <p class="card-text" id="paragraph">Όψη με ενεργά έργα.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_2_a.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" id="row-4">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.2 (Β)</h4>
                        <p class="card-text" id="paragraph">Όψη με έργα ανα ερευνητή.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_2_b.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.3 (Α)</h4>
                        <p class="card-text" id="paragraph">Ενεργά έργα δοσμένου επιστημονικού πεδίου (δώσε επιστημονικό πεδίο).</p>
                        <form action="/project_db/query_3_3_a.php" method="get">
                            <select id="category" name="field_3_3_a" required>
                                <option value="">---</option>
                                <option value="ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ">Φυσικές Επιστήμες</option>
                                <option value="ΤΕΧΝΟΛΟΓΙΑ">Τεχνολογία</option>
                                <option value="ΙΑΤΡΙΚΗ">Ιατρική</option>
                                <option value="ΓΕΩΠΟΝΙΚΗ">Γεωπονική</option>
                                <option value="ΠΛΗΡΟΦΟΡΙΚΗ">Πληροφορική</option>
                                <option value="ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ">Κοινωνικές Επιστήμες</option>
                                <option value="ΤΕΧΝΕΣ">Τέχνες</option>
                                <option value="ΟΙΚΟΝΟΜΙΚΑ">Οικονομικά</option>
                            </select>
                            <a href="/project_db/query_3_3_a.php">
                                <input type="submit" required>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.3 (Β)</h4>
                        <p class="card-text" id="paragraph">Ερευνητές που εργάζονται σε δοσμένο επιστημονικό πεδίο (δώσε επιστημονικό πεδίο).</p>
                        <form action="/project_db/query_3_3_b.php" method="get">
                            <select id="category" name="field_3_3_b" required>
                                <option value="">---</option>
                                <option value="ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ">Φυσικές Επιστήμες</option>
                                <option value="ΤΕΧΝΟΛΟΓΙΑ">Τεχνολογία</option>
                                <option value="ΙΑΤΡΙΚΗ">Ιατρική</option>
                                <option value="ΓΕΩΠΟΝΙΚΗ">Γεωπονική</option>
                                <option value="ΠΛΗΡΟΦΟΡΙΚΗ">Πληροφορική</option>
                                <option value="ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ">Κοινωνικές Επιστήμες</option>
                                <option value="ΤΕΧΝΕΣ">Τέχνες</option>
                                <option value="ΟΙΚΟΝΟΜΙΚΑ">Οικονομικά</option>
                            </select>
                            <a href="/project_db/query_3_3_b.php">
                                <input type="submit" required>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
          </div>
          <br>
          <div class="row" id="row-5">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.4</h4>
                        <p class="card-text" id="paragraph">Οργανισμοί με ίδιο αριθμό έργων σε δυο συνεχόμενα έτη.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_4.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.5 (Α)</h4>
                        <p class="card-text" id="paragraph">Top 3 ζεύγη επιστημονικών πεδίων (με κριτήριο το συνολικό ποσό χρηματοδότησης).</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_5_a.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.5 (Β)</h4>
                        <p class="card-text" id="paragraph">Top 3 ζεύγη επιστημονικών πεδίων (με κριτήριο το συνολικό πλήθος έργων).</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_5_b.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" id="row-6">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.6</h4>
                        <p class="card-text" id="paragraph">Νέοι ερευνητές με τα περισσότερα ενεργά έργα.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_6.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.7</h4>
                        <p class="card-text" id="paragraph">Top 5 στελέχοι που έχουν δώσει τα περισσότερα χρήματα σε εταιρείες.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_7.php">Show</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <h4 class="card-title">Ερώτημα 3.8</h4>
                        <p class="card-text" id="paragraph">Ερευνητές που εργάζονται σε τουλάχιστον 5 έργα χωρίς παραδοτέα.</p>
                        <a class="btn btn-primary" id="show-btn" href="/project_db/query_3_8.php">Show</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src = "{{ url_for('static', filename = 'bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>
