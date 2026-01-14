-- Normalize kode prefixes to new scheme:
-- komputer -> COM0001
-- support  -> SUP0001
-- jaringan -> NET0001

UPDATE inf_ti_items SET kode = CONCAT(
  CASE
    WHEN category = 'komputer' THEN 'COM'
    WHEN category = 'support' THEN 'SUP'
    WHEN category = 'jaringan' THEN 'NET'
    ELSE UPPER(LEFT(category,3))
  END,
  LPAD(id,4,'0')
);

-- Rollback (not implemented): previous kode values are overwritten; keep backups if needed.