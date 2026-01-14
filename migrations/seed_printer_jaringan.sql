-- Migration: seed demo data for Printer and Jaringan with kode values
-- Insert printers if not present
INSERT INTO inf_ti_items (kode, category, name, detail, sn, tahun, kondisi, lokasi, sort_order)
SELECT 'PR-001','printer','HP LaserJet','Pro M404','HP-SN001','2020','Baik','Ruang Cetak',1
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM inf_ti_items WHERE category='printer' AND name='HP LaserJet');

INSERT INTO inf_ti_items (kode, category, name, detail, sn, tahun, kondisi, lokasi, sort_order)
SELECT 'PR-002','printer','Epson L315','InkTank L315','EP-SN002','2021','Baik','Ruang Cetak',2
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM inf_ti_items WHERE category='printer' AND name='Epson L315');

-- Insert jaringan items if not present
INSERT INTO inf_ti_items (kode, category, name, detail, sn, tahun, kondisi, lokasi, sort_order)
SELECT 'JRG-001','jaringan','Switch Lantai 1','24 port Gigabit','SW-SN001','2019','Baik','Lantai 1',1
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM inf_ti_items WHERE category='jaringan' AND name='Switch Lantai 1');

INSERT INTO inf_ti_items (kode, category, name, detail, sn, tahun, kondisi, lokasi, sort_order)
SELECT 'JRG-002','jaringan','Router Kantor','Edge Router 1U','RT-SN002','2018','Baik','Ruang Server',2
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM inf_ti_items WHERE category='jaringan' AND name='Router Kantor');

-- Ensure any existing rows that lack kode get a sensible default based on category + id
UPDATE inf_ti_items
SET kode = CONCAT(
  CASE category WHEN 'komputer' THEN 'KOM-' WHEN 'printer' THEN 'PR-' WHEN 'jaringan' THEN 'JRG-' ELSE UPPER(LEFT(category,3)) END,
  LPAD(id,4,'0')
)
WHERE kode IS NULL OR kode = '';
