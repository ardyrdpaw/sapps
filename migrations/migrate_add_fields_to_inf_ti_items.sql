-- Migration: add sn, tahun, kondisi, lokasi to inf_ti_items
ALTER TABLE inf_ti_items 
  ADD COLUMN sn VARCHAR(100) DEFAULT NULL,
  ADD COLUMN tahun VARCHAR(10) DEFAULT NULL,
  ADD COLUMN kondisi VARCHAR(100) DEFAULT NULL,
  ADD COLUMN lokasi VARCHAR(255) DEFAULT NULL;
