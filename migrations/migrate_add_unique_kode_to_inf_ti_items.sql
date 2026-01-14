-- Ensure no NULL/empty `kode` values exist; generate a sensible kode based on category + id
UPDATE inf_ti_items SET kode = CONCAT(
  CASE
    WHEN category = 'komputer' THEN 'KOM-'
    WHEN category = 'support' THEN 'SUP-'
    WHEN category = 'jaringan' THEN 'JRG-'
    ELSE UPPER(LEFT(category,3)) || '-'
  END,
  LPAD(id,4,'0')
) WHERE kode IS NULL OR kode = '';

-- Add unique index on kode
ALTER TABLE inf_ti_items ADD UNIQUE INDEX uniq_inf_ti_items_kode (kode);

-- Rollback: to drop the index
-- ALTER TABLE inf_ti_items DROP INDEX uniq_inf_ti_items_kode;