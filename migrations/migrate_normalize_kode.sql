-- Migration: normalize kode formats for existing inf_ti_items
-- Standard format:
-- Komputer: KOM-<id padded 4 digits>
-- Support: SUP-<id padded 4 digits>
-- Jaringan: JRG-<id padded 4 digits>

UPDATE inf_ti_items
SET kode = CONCAT(
  CASE category
    WHEN 'komputer' THEN 'KOM-'
    WHEN 'support' THEN 'SUP-'
    WHEN 'jaringan' THEN 'JRG-'
    ELSE CONCAT(UPPER(LEFT(category,3)),'-')
  END,
  LPAD(id,4,'0')
)
WHERE kode IS NULL OR kode = '' OR kode NOT REGEXP '^[A-Z]{3}-[0-9]{4}$';
