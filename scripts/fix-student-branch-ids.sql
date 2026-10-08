-- Run in phpMyAdmin on live if artisan is unavailable (backup first).
-- Fixes students tagged as branch 1 while enrolled in a class that belongs to another branch.

UPDATE students s
INNER JOIN session_class_students scs ON scs.student_id = s.id
INNER JOIN classes c ON c.id = scs.classes_id
SET s.branch_id = c.branch_id
WHERE s.branch_id != c.branch_id OR s.branch_id IS NULL;

UPDATE users u
INNER JOIN students s ON s.user_id = u.id
SET u.branch_id = s.branch_id
WHERE u.branch_id != s.branch_id OR u.branch_id IS NULL;

UPDATE session_class_students scs
INNER JOIN students s ON s.id = scs.student_id
SET scs.branch_id = s.branch_id
WHERE scs.branch_id != s.branch_id OR scs.branch_id IS NULL;
