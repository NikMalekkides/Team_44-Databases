/* Αρχείο, με τα σχετικά script, το οποία κατασκευάζει πλήρως το σχήμα της βάσης.
Σημειώνουμε οτι η βάση κατασκευάστηκε σε MySQL.
ΣΧΕΤΙΚΗ ΟΔΗΓΙΑ: Τρέξε το πάρον script (δημιουργία βάσης).
*/
DROP SCHEMA IF EXISTS project_db;
CREATE SCHEMA project_db;
USE project_db;

-- Πίνακας για την οντότητα "Οργανισμός".
CREATE OR REPLACE TABLE organisation(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  -- Θεωρούμε αυτόματη δεικτοδότησή των εγγραφών ως πρωτεύον κλειδί.
  org_name VARCHAR(100) NOT NULL,
  abbreviation VARCHAR(15) UNIQUE NOT NULL,
  -- Θεωρο΄ύμε οτι η συντομογραφία ενός οργανισμού είναι μοναδική.
  category ENUM('University', 'Research Center', 'Company') NOT NULL,
  -- Θεωρούμε την κατηγορία του οργανισμού ως χαρακτηριστικό του (οχι ως ξεχωριστή οντότητα).
  street VARCHAR(50) NOT NULL,
  street_no BIGINT UNSIGNED NOT NULL,
  postal_code BIGINT UNSIGNED NOT NULL,
  city VARCHAR(50) NOT NULL
  -- Η διεύθυνση ενός οργανισμού, ως σύνθετο χαρακτηριστικό διασπάται στις συνιστώσες του.
);

/* Τα τηλέφωνα επικοινωνίας ενός οργανισμού, ως χαρακτηριστικό πολλαπλών τιμών,
χρειάζεται ξεχωριστό πίνακα. */
CREATE OR REPLACE TABLE phone(
  -- Έστω τα τηλέφωνα είναι 10 ψήφια.
  phone BIGINT UNSIGNED NOT NULL,
  org_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(org_id) REFERENCES organisation(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του οργανισμού στον οποίο ανήκει το τηλέφωνο, θέλουμε να αλλάζει
  αυτόματα και η δεικτοδότησή του στις αντίστοιχες εγγραφές του πίνακα αυτού. */
  PRIMARY KEY(phone, org_id)
);

-- Πίνακας για την οντότητα "Στέλεχος ΕΛΙΔΕΚ".
CREATE OR REPLACE TABLE employee(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  -- Θεωρούμε αυτόματη δεικτοδότησή των εγγραφών ως πρωτεύον κλειδί.
  first_name VARCHAR(30) NOT NULL,
  last_name VARCHAR(30) NOT NULL,
  date_of_birth DATE NOT NULL,
  sex ENUM('M', 'F')
);

-- Πίνακας για την οντότητα "Πρόγραμμα".
CREATE OR REPLACE TABLE program(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  -- Θεωρούμε αυτόματη δεικτοδότησή των εγγραφών ως πρωτεύον κλειδί.
  name VARCHAR(50),
  department ENUM('ΚΑΙΝΟΤΟΜΙΑ', 'ΕΠΕΝΔΥΣΕΙΣ', 'ΑΓΟΡΑ', 'ΑΝΑΚΑΜΨΗ', 'ΑΝΘΡΩΠΟΣ', 'ΠΕΡΙΒΑΛΛΟΝ') NOT NULL
  -- Θεωρούμε οτι υπάρχουν συγκεκριμένα (ήδη γνωστά) τμήματα του ΕΛΙΔΕΚ, στα οποία ανήκουν οι οργανισμο΄ί.
);

/* Πίνακας για την οντότητα "Ερευνητής". Στον ίδιο πίνακα απορρροφάται και
η συσχέτιση εργασίας μεταξύ του Ερευνητή και του Οργανισμού στον οποίο εργάζεται. */
CREATE OR REPLACE TABLE researcher(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  -- Θεωρούμε αυτόματη δεικτοδότησή των εγγραφών ως πρωτεύον κλειδί.
  org_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(org_id) REFERENCES organisation(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του οργανισμού στον οποίο εργάζεται ο ερευνητής,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή του ερευνητή. */
  first_name VARCHAR(30) NOT NULL,
  last_name VARCHAR(30) NOT NULL,
  date_of_birth DATE NOT NULL,
  sex ENUM('M', 'F'),
  works_date DATE NOT NULL CHECK( date_of_birth < works_date )
  /* Ελέγχουμε την προφανής συνθήκη: η ημερομηνία έναρξης της εργασίας του ερευνητή
  στον συγκεκριμένο οργανισμό, είναι μετά την ημερομηνία γέννησής του. */
);

/* Πίνακας για την οντότητα "Έργο". Στον ίδιο πίνακα απορρροφούνται και
οι συσχετίσεις αξιολόγησης (evaluator), επιστημονικο΄ύ υπεύθυνου (supervisor),
στελέχους (controller) και οργανισμού (managing) που το διαχειρίζονται.  */
CREATE OR REPLACE TABLE project(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  -- Θεωρούμε αυτόματη δεικτοδότησή των εγγραφών ως πρωτεύον κλειδί.
  title VARCHAR(100) NOT NULL,
  summary MEDIUMBLOB NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL CHECK( DATEDIFF(end_date,start_date)<=4*365
                                AND DATEDIFF(end_date,start_date)>=365 ),
  /* Ελέγχουμε τη συνθήκη, ότι η συνολική διάρκεια του έργου είναι, τουλάχιστον 1 έτος και το πολύ 4. */
  evaluator_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(evaluator_id) REFERENCES researcher(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του ερευνητή ο οποίος αξιολόγησε το έργο,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή του έργου. */
  evaluator_grade INT NOT NULL CHECK( evaluator_grade BETWEEN 0 AND 100 ),
  -- Θεωρούμε οτι ο βαθμός αξιολόγησης δίνεται ως ακέραιος αριθμός μεταξύ του 0 και 100.
  evaluation_date DATE NOT NULL CHECK( evaluation_date<=start_date ),
  -- Θεωρούμε οτι η αξιολόγηση του έργου έχει γίνει το αργότερο την ημέρα έναρξης του έργου.
  supervisor_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(supervisor_id) REFERENCES researcher(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του ερευνητή ο οποίος είναι επιστημονικός υπέυθυνος του έργου,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή του έργου. */
  controller_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(controller_id) REFERENCES employee(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του στελέχους του ΕΛΙΔΕΚ ο οποίος είναι διαχειρίζεται το έργο,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή του έργου. */
  sponsor_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(sponsor_id) REFERENCES program(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του προγράμματος του ΕΛΙΔΕΚ το οποίο επιχορηγεί το έργο,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή του έργου. */
  sponsor_amount BIGINT UNSIGNED NOT NULL,
  -- Θεωρούμε οτι η αξιολόγηση δίνεται ως θετικός πραγματικός αριθμός.
  managing_org_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(managing_org_id) REFERENCES organisation(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του οργανισμού ο οποίος διαχειρίζεται το έργο,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή του έργου. */
  managing_date DATE NOT NULL CHECK( managing_date<start_date AND managing_date>evaluation_date )
  /* Θεωρούμε οτι ο οργανισμός έχει αρχίσει να διαχειρίζεται το έργο, το αργότερο
  την παραμονή της έναρξης του έργου. Θεωρούμε επίσης ότι ο οργανισμός αναλαμβάνει ένα έργο εφόσον έχει ήδη αξιολογηθεί. */
);

/* Δημιουργούμε 2 δεικτοδοτήσεις στον πίνακα project (έργο), επάνω στα attributes: start_date (ημέρα έναρξης)
και end_date (ημέρα λήξης) καθώς τα χρησιμοποιούμε σε διάφορα ερωτήματα του 3ου μέρους της εργασίας (πχ για
αναζήτηση έργων με βάση τη διάρκεια τους ή εύρεση των ενερ΄γών έργων κτλ)
*/
CREATE OR REPLACE INDEX idx_project_sd ON project(start_date);
CREATE OR REPLACE INDEX idx_project_ed ON project(end_date);
/* Δημιουργούμε ακόμη μια δεικτοδότησή στο attribute managing_date (ημερομηνία όπου ανέλαβε ο αντίστοιχος
οργανισμός το έργο) διότι το σχετικό ερώτημα στο 3ο μέρος, γίνονται διάφορα φιλτραρίσματα με βάση την
ημερομηνία αυτή.*/
CREATE OR REPLACE INDEX idx_project_md ON project(managing_date);

/* Δημιουργούμε και ένα trigger το οποίο πριν απο κάθε εισαγωγή εγγραφής στον πίνακα project
εξετάζει τον περιορισμό: ο ερευνητής που αξιολογεί το έργο δεν πρέπει να εργάζεται στον οργανισμό
που το διαχειρίζεται. Σε περίπτωση παραβίασης του, σταματάει την εισαγωγή και επιστρέφει σχετικό μήνυμα. */
DELIMITER $$
CREATE OR REPLACE TRIGGER check_evaluator
BEFORE INSERT ON project FOR EACH ROW
BEGIN
	IF NEW.managing_org_id = (
                SELECT org_id FROM researcher
								WHERE researcher.id = NEW.evaluator_id
                            ) THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Evaluator shouldn't be working for managing organisation";
  END IF;
END; $$
DELIMITER ;

-- Πίνακας για τη "many to many" συσ΄χέτιση εργασίας μεταξύ ερευνητών και έργων.
CREATE OR REPLACE TABLE works_on(
  project_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του έργου, θέλουμε να αλλάζει αυτόματα
  και η δεικτοδότησή του στην αντίστοιχη εγγραφή της συσχέτισης. */
  researcher_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(researcher_id) REFERENCES researcher(id) ON UPDATE CASCADE,
  /* Ομοίως αν αλλάξει η δεικτοδότηση ενός ερευνητή που εργάζεται στο έργο,
  θέλουμε να αλλάζει αυτόματα και η δεικτοδότησή του στην αντίστοιχη εγγραφή. */
  PRIMARY KEY(project_id, researcher_id)
);

/* Δημιουργούμε μια όψη/view, όπου αποθηκεύουμε την πλήρης πληροφορία της συσχέτισης works_on (μεταξ΄ύ
έργου και ερευνητή), δηλαδή ως εγγραφές του έχει τα στοιχεία του έργου μαζί με τα στοιχεία του ερευνητή
που εργάζεται σ'αυτό, όπου αυτό συμβάινει για κάθε έργο και για κάθε ερευνητή που εργάζεται σ' αυτό.
Η ανάγκη του εμφανίζεται στο ότι χρειαζόμαστε συχνά το τριπλό join μεταξύ project, researcher και works_on. */
CREATE OR REPLACE VIEW researcher_project AS
  SELECT * FROM
  (SELECT id AS res_id, org_id, first_name, last_name,
  		date_of_birth, sex, works_date, project_id FROM
  researcher INNER JOIN works_on
  ON researcher.id = works_on.researcher_id) AS temp
  INNER JOIN project
  ON temp.project_id = project.id;

/* Δημιουργούμε επίσης ένα view, οπου διατηρούμε τα ενεργά έργα στη βάση, καθώς τα επικαλούμαστε
συχνά στα ερωτήματα του 3ου μέρους (ενεργά με βάση την ημερομηνία που δημιουργέιται το view). */
CREATE OR REPLACE VIEW active_projects AS
  SELECT * FROM
  project WHERE( start_date<=CURRENT_DATE() AND end_date>CURRENT_DATE() );

/* Δημιουργούμε ακόμη ένα view, όπου αποθηκεύουμε τα χαρακτηριστικά των project μαζί με τα
αντίστοιχα χαρακτηριστικά των οργανισμών που τα διαχειρίζονται. Το δημιουργούμε κα΄θώς χρειαζόμαστε
συχνά την πληροφορία του συγκεκριμένου join. */
CREATE OR REPLACE VIEW project_organisation AS
  SELECT * FROM
  project INNER JOIN (
          SELECT id org_id, org_name, abbreviation, category, street,
                      street_no, postal_code, city FROM organisation
                      ) AS temp
  ON project.managing_org_id = temp.org_id;

/* Τα επιστημονικά πε΄δίο ενός έργου, ως χαρακτηριστικό πολλαπλών τιμών,
χρειάζεται ξεχωριστό πίνακα. */
CREATE OR REPLACE TABLE field(
  project_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE,
  field_name ENUM('ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ', 'ΤΕΧΝΟΛΟΓΙΑ', 'ΙΑΤΡΙΚΗ', 'ΓΕΩΠΟΝΙΚΗ', 'ΠΛΗΡΟΦΟΡΙΚΗ', 'ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ', 'ΤΕΧΝΕΣ', 'ΟΙΚΟΝΟΜΙΚΑ') NOT NULL,
  /* Θεωρούμε οτι υπάρχουν συγκεκριμένα (ήδη γνωστά) επιστημονικά, στα οποία ανήκουν ένα έργο.
  Δεν επι΄βάλλουμε κάποιο περιορισμό ως προς το πλήθος πεδίων στα οποία μπορεί να ανήκει ένα έργο. */
  PRIMARY KEY(project_id, field_name)
);

-- Πίνακας για την ασθενής οντότητα "παραδοτέο", η οποία στηρίζεται στην οντότητα "έργο".
CREATE OR REPLACE TABLE report(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  -- Θεωρούμε αυτόματη δεικτοδότησή των εγγραφών ως πρωτεύον κλειδί.
  project_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(project_id) REFERENCES project(id) ON UPDATE CASCADE,
  /* Αν αλλάξει η δεικτοδότηση του (parent) έργου, θέλουμε να αλλάζει αυτόματα
  και η δεικτοδότησή του στην αντίστοιχη εγγραφή του παραδοτέου. */
  title VARCHAR(100) NOT NULL,
  summary MEDIUMBLOB NOT NULL,
  delivery_date DATE NOT NULL,
  PRIMARY KEY(id, project_id)
);
