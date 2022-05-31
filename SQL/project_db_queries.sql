/* Δίνουμε ενδεικτικά τα queries που χρησιμοποιούνται για την επίλυση
των ερωτημάτων του μέρους 3 της εργασίας, δηλαδή τα queries που καλεί το
UI-php για τη εμφάνιση των αποτελεσμάτων.
*/

---------- ΕΡΩΤΗΜΑ 3.1 (A)
-- Όλα τα προγράμματα που είναι διαθέσιμα.
SELECT * FROM program;

---------- ΕΡΩΤΗΜΑ 3.1 (Β)
-- Ερευνητές που εργάζονται σε δοσμένο έργο (δώσε ID έργου). (πχ id = '23')
SELECT res_id, first_name, last_name, org_id
FROM researcher_project WHERE project_id = '23';

---------- ΕΡΩΤΗΜΑ 3.1 (C)
-- Έργα τα οποία θα είναι ενεργά σε δοσμένη ημερομηνία (είσοδος απο χρήστη).
-- (πχ date = '2022-09-15')
SELECT * FROM project
WHERE start_date<='2022-09-15' AND end_date>'2022-09-15';

---------- ΕΡΩΤΗΜΑ 3.1 (D)
-- Έργα τα οποία χειρίζεται δοσμένο στέλεχος (δώσε ID στελέχους). (πχ id = '13')
SELECT * FROM project
WHERE controller_id = '13';

---------- ΕΡΩΤΗΜΑ 3.1 (E)
-- Έργα με διάρκεια μικρότερη απο δοσμένο όριο. (δώσε διάρκεια σε έτη).
-- (πχ duration = 3.2 έτη)
SELECT *, TRUNCATE(DATEDIFF(end_date,start_date)/365,2) duration FROM project
WHERE DATEDIFF(end_date,start_date)<=365*3.2;

---------- ΕΡΩΤΗΜΑ 3.2 (Α)
-- Όψη με ενεργά έργα.
SELECT * FROM active_projects;

---------- ΕΡΩΤΗΜΑ 3.2 (Β)
-- Όψη με έργα ανα ερευνητή.
SELECT res_id, first_name, last_name, project_id, title, start_date, end_date
FROM researcher_project;

---------- ΕΡΩΤΗΜΑ 3.3 (Α)
-- Ενεργά έργα δοσμένου επιστημονικού πεδίου (δώσε επιστημονικό πεδίο). (πχ field = ΙΑΤΡΙΚΗ)
SELECT * FROM
active_projects ap INNER JOIN field ON ap.id = field.project_id
WHERE field_name = 'ΙΑΤΡΙΚΗ';

---------- ΕΡΩΤΗΜΑ 3.3 (B)
-- Ερευνητές που εργάστηκαν στο δοσμένο επιστημονικό πεδίο
-- το τελευταίο έτος (δώσε επιστημονικό πεδίο). (πχ field = ΙΑΤΡΙΚΗ)
SELECT res_id, first_name, last_name, date_of_birth, sex, works_date FROM
researcher_project rp INNER JOIN field ON rp.id = field.project_id
WHERE( field_name = 'ΙΑΤΡΙΚΗ' AND start_date<=CURRENT_DATE()
			 AND end_date>DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR) );

---------- ΕΡΩΤΗΜΑ 3.4
-- Οργανισμοί με ίδιο αριθμό έργων σε δυο συνεχόμενα έτη.
CREATE OR REPLACE TEMPORARY TABLE temp
	SELECT org_id , YEAR(managing_date) m_year, COUNT(*) no_projects
	FROM project_organisation
	GROUP BY org_id, m_year
	HAVING no_projects>=10;
-----
CREATE OR REPLACE TEMPORARY TABLE temp2
	SELECT t1.org_id, t1.m_year year1, t1.no_projects year1_count,
				 t2.m_year year2, t2.no_projects year2_count
  FROM temp t1 INNER JOIN temp t2
  ON t1.org_id = t2.org_id AND t1.m_year = t2.m_year-1;
-----
CREATE OR REPLACE TEMPORARY TABLE results
	SELECT t1.org_id id1, t2.org_id id2, t1.year1, t1.year2,
				 t1.year1_count + t1.year2_count total
	FROM temp2 t1 INNER JOIN temp2 t2
	ON t1.year1 = t2.year1
	WHERE t1.org_id<t2.org_id AND t1.year1_count+t1.year2_count = t2.year1_count+t2.year2_count;


---------- ΕΡΩΤΗΜΑ 3.5 (A)
-- Top 3 ζεύγη επιστημονικών πεδίων (με κριτήριο το συνολικό ποσό χρηματοδότησης).
CREATE TEMPORARY TABLE field_pairs
  SELECT f1.field_name field1, f2.field_name field2, f1.project_id id FROM
  field f1 INNER JOIN field f2 ON f1.project_id = f2.project_id
  WHERE f1.field_name < f2.field_name;
-----
SELECT field1, field2, SUM(project.sponsor_amount) total FROM
field_pairs INNER JOIN project on field_pairs.id = project.id
GROUP BY field1, field2 ORDER BY total DESC LIMIT 3;

---------- ΕΡΩΤΗΜΑ 3.5 (B)
-- Top 3 ζεύγη επιστημονικών πεδίων (με κριτήριο το συνολικό πλήθος έργων).
CREATE TEMPORARY TABLE field_pairs
  SELECT f1.field_name field1, f2.field_name field2, f1.project_id id FROM
  field f1 INNER JOIN field f2 ON f1.project_id = f2.project_id
  WHERE f1.field_name < f2.field_name;
-----
SELECT field1, field2, COUNT(*) freq FROM field_pairs
GROUP BY field1, field2 ORDER BY freq DESC LIMIT 3;

---------- ΕΡΩΤΗΜΑ 3.6
-- Νέοι ερευνητές με τα περισσότερα ενεργά έργα.
CREATE OR REPLACE TEMPORARY TABLE temp
  SELECT first_name, last_name, COUNT(*) no_projects  FROM
  active_projects ac INNER JOIN researcher_project rp
  ON ac.id = rp.id
  WHERE rp.date_of_birth>DATE_ADD(CURRENT_DATE(), INTERVAL -40 YEAR)
  GROUP BY rp.id ORDER BY no_projects;
-----
SELECT * FROM temp
WHERE no_projects = (SELECT MAX(no_projects) FROM temp);

---------- ΕΡΩΤΗΜΑ 3.7
-- Top 5 στελέχοι που έχουν δώσει τα περισσότερα χρήματα σε εταιρείες.
SELECT first_name, last_name, org_name, SUM(sponsor_amount) total FROM
employee INNER JOIN (
          SELECT * FROM project_organisation
          WHERE category = 'Company'
                    ) AS temp
ON employee.id = temp.controller_id
GROUP BY employee.id, temp.org_id
ORDER BY total DESC LIMIT 5;

---------- ΕΡΩΤΗΜΑ 3.8
-- Ερευνητές που εργάζονται σε τουλάχιστον 5 έργα χωρίς παραδοτέα.
CREATE OR REPLACE TEMPORARY TABLE temp
	SELECT id FROM active_projects
	WHERE id NOT IN (
              SELECT ap.id FROM
	            active_projects ap INNER JOIN report
	            ON ap.id = report.project_id
              GROUP BY ap.id
              		);
-----
SELECT first_name, last_name, COUNT(*) no_projects FROM
researcher_project rp
WHERE rp.id IN (SELECT * FROM temp)
GROUP BY rp.res_id HAVING no_projects>=5 ORDER BY no_projects;
