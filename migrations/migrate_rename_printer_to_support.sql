-- Migration: rename category 'printer' to 'support'
UPDATE inf_ti_items SET category = 'support' WHERE category = 'printer';
-- Optional: adjust kode prefix 'PR-' -> 'SUP-' for items that start with PR-
UPDATE inf_ti_items SET kode = CONCAT('SUP-', SUBSTRING(kode,4)) WHERE kode LIKE 'PR-%';
