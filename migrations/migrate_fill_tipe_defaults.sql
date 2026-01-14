-- Fill sensible defaults for the `tipe` column based on category and content
UPDATE inf_ti_items SET tipe =
  CASE
    WHEN category = 'komputer' AND (LOWER(name) LIKE '%laptop%' OR LOWER(detail) LIKE '%laptop%' OR LOWER(name) LIKE '%notebook%') THEN 'Laptop'
    WHEN category = 'komputer' THEN 'PC'

    WHEN category = 'support' AND (LOWER(name) LIKE '%printer%' OR LOWER(detail) LIKE '%printer%' OR LOWER(name) LIKE '%epson%' OR LOWER(name) LIKE '%hp%' OR LOWER(name) LIKE '%brother%') THEN 'Printer'
    WHEN category = 'support' THEN 'Lainnya'

    WHEN category = 'jaringan' AND (LOWER(name) LIKE '%router%' OR LOWER(detail) LIKE '%router%') THEN 'Router'
    WHEN category = 'jaringan' AND (LOWER(name) LIKE '%hub%' OR LOWER(detail) LIKE '%hub%') THEN 'Hub'
    WHEN category = 'jaringan' AND (LOWER(name) LIKE '%adapter%' OR LOWER(detail) LIKE '%adapter%') THEN 'Adapter'
    WHEN category = 'jaringan' THEN 'Lainnya'

    ELSE 'Lainnya'
  END
WHERE tipe IS NULL OR tipe = '';

-- NOTE: this is a best-effort backfill. Review rows after running if you want more specific values.
