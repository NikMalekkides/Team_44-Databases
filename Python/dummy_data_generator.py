# Αρχείο, με τον κώδικα, ο οποίος παράγει τυχαία δεδομένα για να γεμίσει τη βάση.
# ΣΧΕΤΙΚΗ ΟΔΗΓΙΑ: Το txt αρχείο "dummy_data.txt" έχει παραχθεί με τον πιο κάτω κώδικα.
#                 Ενδεικτικά όμως θα συμβουλεύαμε να διαβαστεί για πληρέστερη κατανόηση
#                 των περιορισμών που προσθέσαμε στη βάση.

from faker import Faker
import random
import datetime
from datetime import date

# Δημιουργούμε δική μας συνάρτηση με την οποία προσθέτουμε έτη σε κάποια ημερομηνία.
def add_years(d, years):
    try:
        return d.replace(year = d.year + years)
    except ValueError:
        return d + (date(d.year + years, 1, 1) - date(d.year, 1, 1))

# Δημιουργούμε ενα αντικείμενο faker με το οποίο παράγουμε δεδομένα στα ελληνικά.
f = Faker(["el_GR"])
# Δημιουργούμε ακόμη ένα αντικείμενο faker, με το οποίο παράγουμε δεδομένα στα αγγλικά.
# (υπάρχουν συναρτήσεις όπου η κλάση faker δεν παράγει δεδομένα στα ελληνικά, πχ zipcode() )
ff = Faker()

# Ανοίγουμε ενα txt αρχείο στο οποίο "γράφουμε" τα queries.
dummy_data = open('dummy_data.txt', 'w')

# Ορίζουμε τα πλήθη ως μεταβλητές, σε περίπτωση που θέλουμε να πειραματιστούμε
# με τα δεδομένα.
no_organisations = 30
no_programs = 10
no_researchers = 100
no_employees = 30
no_projects = 300
no_reports = 50 # Πόσα απ'τα έργα να έχουνε παραδοτέα.

########## Οργανισμοι:
# Θα παράξουμε συνολικά 30 οργανισμούς.
for _ in range(no_organisations):
    # Όνομα οργανισμού.
    name = f.company()
    # Δημιουργούμε μια τυχαία συντομογραφία με βάση τα 4 πρώτα
    # και 4 τελευταία γράμματα του ονόματος.
    abbr = name[:4]+"-"+name[-4:]
    # Επιλέγουμε τυχαία ένα απ' τους 3 δείκτες με βάση τον οποίο
    # επιλέγουμε την κατηγορία της εταιρίας.
    i = random.choice([1,2,3])
    switcher = {
        1: "University",
        2: "Research Center",
        3: "Company",
    }
    category = switcher.get(i)
    # Διεύθυνση εταιρίας (σύνθετο attribute):
    # Οδός
    street = f.street_name()
    # Αριθμός
    street_no = ff.building_number()
    # Ταχυδρομικός κώδικας
    postal_code = ff.zipcode()
    # Πόλη
    city = f.city()
    # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
    string = "INSERT INTO organisation VALUES(NULL, '"+name+"', '"+abbr+"', '"+category+"', '"+street+"', "+street_no+", "+postal_code+", '"+city+"');"
    # "Γράφουμε" το query στο αρχείο.
    dummy_data.write("%s\n" % string)
##########

########## Ερευνητές:
# Θα παράξουμε συνολικά 100 ερευνητές.
for _ in range(no_researchers):
    # Επιλέγουμε τυχαία κάποιον απ' τους οργανισμούς, στον οποίον θα εργάζεται
    # ο ερευνητής.
    org_id = random.choice(list(range(1,no_organisations+1)))
    # Όνομα ερευνητή.
    fname = f.first_name()
    # Επίθετο ερευνητή.
    lname = f.last_name()
    # Ημερομηνία γέννησής του (τ.ω. να είναι μεταξύ 18 και 65 ετών).
    dbirth = f.date_between(start_date="-65y", end_date="-18y")
    # Επιλέγουμε τυχαία ένα απ' τους 2 δείκτες με βάση τον οποίο καθορίζουμε το φύλο του.
    i = random.choice([1,2])
    switcher = {
        1: "M",
        2: "F",
    }
    sex = switcher.get(i)
    # Παράγουμε τυχαία ημερομηνία στην οποία ξεκίνησε να δουλεύει για τον οργανισμό του,
    # τ.ω. ο ίδιος να είναι τουλάχιστον 18 χρονών.
    wdate = f.date_between_dates(date_start = add_years(dbirth,18))
    # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
    string = "INSERT INTO researcher VALUES(NULL, '"+str(org_id)+"', '"+fname+"' , '"+lname+"' , '"+str(dbirth)+"', '"+sex+"' , '"+str(wdate)+"');"
    # "Γράφουμε" το query στο αρχείο.
    dummy_data.write("%s\n" % string)
##########

########## Τηλέφωνα οργανισμού:
for j in range(no_organisations):
    # Έστω οτι ο κάθε οργανισμός έχει απο 1 μέχρι 5 νούμερα.
    # Τυχαία επιλέγουμε ενα δείκτη ο οποίος καθορίζει πόσα νούμερα
    # θα έχει ο τρέχον οργανισμός σε κάθε επανάληψη.
    i = random.choice([1,2,3,4,5])
    for _ in range(i):
        # Έστω οτι τα τηλέφωνα είναι 10ψήφια.
        num = f.bothify('##########')
        # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
        string = "INSERT INTO phone VALUES("+num+", '"+str(j+1)+"');"
        # "Γράφουμε" το query στο αρχείο.
        dummy_data.write("%s\n" % string)
##########

########## Στελέχοι ΕΛΙΔΕΚ:
for _ in range(no_employees):
    # Όνομα στελέχους.
    fname = f.first_name()
    # Επ΄ίθετο στελέχους.
    lname = f.last_name()
    # Ημερομηνία γέννησής του (τ.ω. να είναι μεταξύ 18 και 65 ετών).
    dbirth = f.date_between(start_date="-65y", end_date="-18y")
    # Επιλέγουμε τυχαία ένα απ' τους 2 δείκτες με βάση τον οποίο καθορίζουμε το φύλο του.
    i = random.choice([1,2])
    switcher = {
        1: "M",
        2: "F",
    }
    sex = switcher.get(i)
    # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
    string = "INSERT INTO employee VALUES(NULL, '"+fname+"' , '"+lname+"' , '"+str(dbirth)+"' , '"+sex+"');"
    # "Γράφουμε" το query στο αρχείο.
    dummy_data.write("%s\n" % string)
##########


########## Προγράμματα ΕΛΙΔΕΚ:
# Κατασκευάζουμε χειροκίνητα 10 προγράμματα. Έστω οι διευθύνσεις/departments του ΕΛΙΔΕΚ
# στις οποίες αν΄ήκουν τα προγράμματα, είναι γνωστές εκ των προτέρων (όπως τις δίνουμε πιο κάτω).
# Σχόλιο: μεριμνούμε και στη βάση να υπάρχει σχετικός περιορισμός στο πεδίο ορισμού του attribute.
prog_name = ['ΕΣΠΑ', 'ΌΡΙΖΩΝ ΕΥΡΩΠΗ', 'TER', 'ΨΗΦΙΑΚΗ ΕΥΡΩΠΗ', 'FISCALIS', 'rescEU', 'EU4HEALTH', 'Erasmus+', 'ΕΓΤΑΑ', 'LIFE']
departments = ['ΚΑΙΝΟΤΟΜΙΑ', 'ΕΠΕΝΔΥΣΕΙΣ', 'ΑΓΟΡΑ', 'ΑΝΑΚΑΜΨΗ', 'ΑΝΘΡΩΠΟΣ', 'ΠΕΡΙΒΑΛΛΟΝ']

# Παραθέτουμε τα πιο πάνω strings, παράγοντας τα queries εισαγωγής.
# "Γράφουμε" τα queries στο αρχείο.
string = "INSERT INTO program VALUES(NULL, 'ΕΣΠΑ', 'ΚΑΙΝΟΤΟΜΙΑ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'ΟΡΙΖΩΝ ΕΥΡΩΠΗ','ΚΑΙΝΟΤΟΜΙΑ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'TER','ΚΑΙΝΟΤΟΜΙΑ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'ΨΗΦΙΑΚΗ ΕΥΡΩΠΗ','ΕΠΕΝΔΥΣΕΙΣ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'FISCALIS','ΑΓΟΡΑ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'rescEU','ΑΝΑΚΑΜΨΗ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'EU4HEALTH','ΑΝΑΚΑΜΨΗ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'Erasmus+','ΑΝΘΡΩΠΟΣ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'ΕΓΤΑΑ','ΠΕΡΙΒΑΛΛΟΝ');";
dummy_data.write("%s\n" % string)
string = "INSERT INTO program VALUES(NULL, 'LIFE','ΠΕΡΙΒΑΛΛΟΝ');";
dummy_data.write("%s\n" % string)
##########

########## Έργα
list_programs = list(range(1,no_programs+1))
list_organisations = list(range(1,no_organisations+1))
list_employees = list(range(1,no_employees+1))
list_researchers = list(range(1,no_researchers+1))
# Έστω οι επιχορηγήσεις είναι ακέραιος αριθμός απο 50.000 μέχρι και 10.000.000 ευρώ.
list_amount = list(range(50000,10000000))

# Αποθηκεύουμε σε 2 λίστες τις ημερομηνίες έναρξης και λήξης των έργων. Θα μας
# χρησιμεύσουν στην παραγωγή των παραδοτέων πιο κάτω.
dates_start = []
dates_end = []

for _ in range(no_projects):
    # Τίτλος έργου.
    title = f.sentence(nb_words=7)
    # Περίληψη έργου.
    summary = f.sentence(nb_words=20)
    # Ημερομηνία έναρξής του. Εν γένει δεν υπάρχει στη βάση περιορισμός ως προς
    # το πόσο πριν ή μετά απο σήμερα μπορεί να έχει ξεκινήσει/θα ξεκινήσει το έργο.
    # Εμείς επιλέγουμε να έχει ξεκινήσει το πολύ πριν 3 χρ΄όνια, ή το πολύ μετά
    # απο 3 χρόνια, ώστε τα queries να δώσουν ουσιαστικά αποτελέσματα.
    start_date = f.date_between(start_date="-3y",end_date="+3y")
    # Προσθέτουμε την ημερομηνία έναρξης στην λίστα.
    dates_start.append(start_date)
    # Επιλέγουμε την ημερομηνία λήξης του με τέτοιο τρόπο, ώστε να διαρκεί το πολύ 4 χρόνια και
    # κατ'ελάχιστο 1 χρόνο. Στη βάση ελέγχουμε τη συνθήκη αυτή με κατάλληλο περιορισμό.
    end_date = f.date_between_dates(date_start = add_years(start_date,1), date_end = add_years(start_date,4))
    # Προσθέτουμε την ημερομηνία λήξης στην λίστα.
    dates_end.append(end_date)
    # Επιλέγουμε τυχαία στέλεχος του ΕΛΙΔΕΚ που θα διαχειρίζεται το έργο.
    control_id = random.choice(list_employees)
    # Επιλέγουμε τυχαία ερευνητή που θα είναι επιστημονικός υπεύθυνος του έργου.
    super_id = random.choice(list_researchers)
    # Επιλέγουμε τυχαία ερευνητή που θα αξιολογήσει το έργο.
    eval_id = random.choice(list_researchers)
    # Επιλέγουμε τυχαία έναν ακέραιο απ'το 1 μέχρι το 100, ως βαθμό αξιολόγησης του έργου.
    # Στη βάση θεωρούμε οτι ο βαθμός αξιολόγησης είναι ακέραιος μεταξύ 0 και 100.
    grade = random.choice(list(range(1,101)))
    # Επιλέγουμε τυχαία ημερομηνία αξιολόγησης του έργου. Προφανώς πρέπει να έχει γίνει πριν την έναρξη
    # του έργου. Εν γένει στη βάση μόνο αυτό ελέγχετε, εδώ όμως παράγουμε ημερομηνίες αξιολόγησης, απο 1 μέχρι και
    # 3 χρόνια πριν την έναρξη του έργου.
    eval_date = f.date_between_dates(date_start = add_years(start_date,-3), date_end = add_years(start_date,-1))
    # Επιλέγουμε τυχαία ποιός οργανισμός θα διευθύνει το έργο. Στη βάση υπάρχει ο περιορισμός:
    # ο ερευνητής που αξιολογεί το έργο δεν πρέπει να εργάζεται στην εταιρία που το διαχειρίζεται
    # (δηλαδή κάποια απ'τα έργα που θα παράξουμε θα απορριφθούν απο τη βάση λόγω του περιορισμού αυτού).
    man_id = random.choice(list_organisations)
    # Επιλέγουμε τυχαία την ημερομηνία, όπου ανέλαβε ο οργανισμός το έργο. Έστω οτι το αναλαμβάνει
    # αφού έχει γίνει η αξιολόγηση αλλά προφανώς πριν την έναρξή του.
    man_date = f.date_between_dates(date_start = eval_date, date_end = start_date)
    # Επιλέγουμε τυχαία ένα απ'τα προγράμματα, το οποίο θα επιχορηγεί το έργο.
    sponsor_id = random.choice(list_programs)
    # Επιλέγουμε τυχαία το ποσό επιχορήγησης.
    amount = random.choice(list_amount)
    # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
    string = "INSERT INTO project VALUES(NULL, '"+title+"', '"+summary+"', '"+str(start_date)+"', '"+str(end_date)+"', '"+str(eval_id)+"', '"+str(grade)+"', '"+str(eval_date)+"', '"+str(super_id)+"', '"+str(control_id)+"', '"+str(sponsor_id)+"', '"+str(amount)+"', '"+str(man_id)+"', '"+str(man_date)+"');"
    # "Γράφουμε" το query στο αρχείο.
    dummy_data.write("%s\n" % string)
####################################################################################3

########## Επιστημονικά Πεδία:
# Έστω οι επιλογές επιστημονικών πεδίων είναι γνωστές (τις δίνουμε πιο κάτω)
# Σχόλιο: μεριμνούμε να υπάρχει στη βάση σχετικός περιορισμός στο πεδίο ορισμού του attribute.
fields = ['ΦΥΣΙΚΕΣ ΕΠΙΣΤΗΜΕΣ', 'ΤΕΧΝΟΛΟΓΙΑ', 'ΙΑΤΡΙΚΗ', 'ΓΕΩΠΟΝΙΚΗ', 'ΠΛΗΡΟΦΟΡΙΚΗ', 'ΚΟΙΝΩΝΙΚΕΣ ΕΠΙΣΤΗΜΕΣ', 'ΤΕΧΝΕΣ', 'ΟΙΚΟΝΟΜΙΚΑ']

for j in range(no_projects):
    # Επιλέγουμε τυχαία ένα δείκτη που καθορίζει αν ένα έργο θα έχει 1,2 ή 3 πεδία.
    # Στη βάση δεν έχουμε κάποιο περιορισμό σε περ΄ίπτωση που κάποιο έργο έχει περισσότερα.
    k = random.choice([1,2,3])
    if k == 3:
        # Επιλέγουμε τυχαία 3 πεδία απ'τα πιο πάνω.
        f_2 = random.sample(fields, 3)
        # Παραθέτουμε τα πιο πάνω strings, παράγοντας τα queries εισαγωγής.
        # "Γράφουμε" τα queries στο αρχείο.
        string = "INSERT INTO field VALUES("+str(j+1)+", '"+f_2[0]+"');"
        dummy_data.write("%s\n" % string)
        string = "INSERT INTO field VALUES("+str(j+1)+", '"+f_2[1]+"');"
        dummy_data.write("%s\n" % string)
        string = "INSERT INTO field VALUES("+str(j+1)+", '"+f_2[2]+"');"
        dummy_data.write("%s\n" % string)
    elif k == 2:
        # Επιλέγουμε τυχαία 2 πεδία απ'τα πιο πάνω.
        f_2 = random.sample(fields, 2)
        # Παραθέτουμε τα πιο πάνω strings, παράγοντας τα queries εισαγωγής.
        # "Γράφουμε" τα queries στο αρχείο.
        string = "INSERT INTO field VALUES("+str(j+1)+", '"+f_2[0]+"');"
        dummy_data.write("%s\n" % string)
        string = "INSERT INTO field VALUES("+str(j+1)+", '"+f_2[1]+"');"
        dummy_data.write("%s\n" % string)
    else:
        # Επιλέγουμε τυχαία κάποιο πεδίο απ'τα πιο πάνω.
        f_1 = random.choice(fields)
        # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
        # "Γράφουμε" τα queries στο αρχείο.
        string = "INSERT INTO field VALUES("+str(j+1)+", '"+f_1+"');"
        dummy_data.write("%s\n" % string)
##########

########## Παραδοτέα:
# Επιλέγουμε τυχαία, ποιά απ'τα έργα θα έχουν παραδετέα.
sample = random.sample(list(range(1,no_projects+1)), no_reports)
for item in sample:
    # Έστω οτι ενα έργο έχει το πολύ 5 παραδετέα.
    # Στη βάση δεν έχουμε κάποιο περιορισμό σε περ΄ίπτωση που κάποιο έργο έχει περισσότερα.
    j = random.choice([1,2,3,4,5])
    for _ in range(j):
        # Τίτλος παραδετέου.
        title = f.sentence(nb_words=7)
        # Περίληψη παραδοτέου.
        summary = f.sentence(nb_words=20)
        # Ημερομηνία παράδοσης. Προφανώς πρέπει να είναι τέτοια ώστε το parent έργο
        # να είναι ακόμη ενεργό (δηλαδή η ημερομηνία να είναι μεταξύ της αντ΄ίστοιχης
        # ημερομηνίας έναρξης και λήξης).
        dev_date = f.date_between(start_date=dates_start[item-1], end_date=dates_end[item-1])
        # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
        string = "INSERT INTO report VALUES(NULL, '"+str(item)+"', '"+title+"', '"+summary+"', '"+str(dev_date)+"');"
        # "Γράφουμε" το query στο αρχείο.
        dummy_data.write("%s\n" % string)
##########

########## Συσχέτιση "εργάζεται" μεταξύ έργου και ερευνητή:
for i in range(1,no_projects+1):
    # Έστω οτι σε κάθε έργο εργάζονται απο 3 μέχρι 8 ερευνητές.
    # Στη βάση δεν έχουμε κάποιο περιορισμό σε περ΄ίπτωση που κάποιο έργο έχει περισσότερους.
    # Επιλέγουμε τυχαία το πλήθος εργαζομένων.
    j = random.choice(list(range(3,8)))
    # Επιλέγουμε τυχαία δείγμα απ'τους ερευνητές με βάση το πιο πάνω πλήθος.
    sam = random.sample(list(range(1,no_researchers+1)), j)
    for item in sam:
        # Παραθέτουμε τα πιο πάνω strings, παράγοντας το query εισαγωγής.
        string = "INSERT INTO works_on VALUES('"+str(i)+"', '"+str(item)+"');"
        # "Γράφουμε" το query στο αρχείο.
        dummy_data.write("%s\n" % string)
##########

# Κλείνουμε το txt αρχείο στο οποίο "γράφουμε" τα queries.
dummy_data.close()

# ΕΠΙΠΛΕΟΝ ΣΧΟΛΙΟ: Όπως αναφέραμε πιο πάνω, λόγω του περιορισμού σχετικά με τον αξιολογητή
#                  του έργου, κάποια queries θα απορριφθούν απο τη βάση. Κατα συνέπεια θα απορριφθούν
#                  και κάποια επιπλέον queries τα οποία τα χρησιμοποιούν σε συνθήκες foreign key.
