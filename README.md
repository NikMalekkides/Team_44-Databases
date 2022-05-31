# Team-44---Databases
Παραδοτέο 2 της εξαμηνιαίας εργασίας του μαθήματος Βάσεων Δεδομένων.

Σημειώνουμε αρχικά οτι ο κώδικας της SQL εχει γραφτεί σε περιβάλλον MySQL Workbench και DBeaver.

Αρχικά τρέξτε το αρχείο project_db_tables.sql το οποίο βρίσκεται εντός του φακέλου SQL. Το αρχείο αυτό θα κατασκευάσει το σχήμα, τους πίνακες, τις όψεις, τα ευρετήρια και τα triggers. 

Έπειτα τρέξτε το αρχείο project_db_insert.sql το οποίο βρίσκεται εντός του φακέλου SQL. Το αρχείο αυτό εισάγει τα ψευδο-δεδομένα που παράξαμε στη βάση. Σε περίπτωση που το κείμενο του αρχείου έχει μεταφράσει τα ελληνικά σε σύμβολα, έχουμε προσθέσει εντός του φακέλου SQL ένα αρχείο word μέσα στο οποίο βρίσκονται όλες οι εντολές εισαγωγής που βρίσκονται και εντός του script. Ομοίως για τον ίδιο λόγο υπάρχει και το dummy_data.txt εντός του φακέλου. 

Απομένει η εγκατάσταση του user interface. Θα εξηγήσουμε τα διαδικαστικά σε περίπτωση που χρησιμοιποείτε XAMPP όπως εμείς. Αντιγράφεται τον φάκελο project_db και τον τοποθετείτε εντός του φακέλο htdocs που βρίσκεται εντός του φακέλου xampp που βρίσκεται στο δίσκο σας. 

Σε περίπτωση που χρησιμοποιείτε κάποιο άλλο web development stack, ακολουθείστε τα ανάλογα βήματα για την αντιγραφή του φακέλου project_db. Σ' αυτή την περίπτωση όμως, πηγαίνετε στο αρχείο db_connect.php το οποίο βρίσκεται εντός του φακέλου project_db και τροποιήστε τις μεταβλητές: $servername, $username και $password ώστε να ανταποκρίνονται στα δεδομένα της δικής σας σύνδεσης.

Έχοντας κάνει τα πιο πάνω, εαν πάτε στο σύνδεσμο: http://localhost/project\_db/index.php θα μπορείτε να δείτε το περιβάλλον της εφαρμογής μας, καθώς και να εκτελέσετε τα της εκφώνησης.
