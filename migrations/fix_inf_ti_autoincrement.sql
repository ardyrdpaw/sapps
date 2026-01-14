-- Fix inf_ti_items id column if it contains id=0 and ensure auto_increment is enabled
-- 1) If there is a row with id = 0, assign it a new id = MAX(id)+1
SET @mx := (SELECT COALESCE(MAX(id), 0) FROM inf_ti_items);
UPDATE inf_ti_items SET id = @mx + 1 WHERE id = 0;

-- 2) Modify id column to be AUTO_INCREMENT (MySQL will use MAX(id)+1 as next value)
ALTER TABLE inf_ti_items MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT;

-- Done
