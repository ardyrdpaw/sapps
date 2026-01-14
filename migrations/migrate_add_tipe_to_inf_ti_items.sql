-- Add 'tipe' column to inf_ti_items
ALTER TABLE inf_ti_items ADD COLUMN tipe VARCHAR(100) DEFAULT NULL;

-- Optional: set defaults for existing rows (left NULL to let user set meaningful values)

-- Rollback: to drop the column
-- ALTER TABLE inf_ti_items DROP COLUMN tipe;