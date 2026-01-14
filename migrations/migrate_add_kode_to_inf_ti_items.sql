-- Migration: add kode to inf_ti_items
ALTER TABLE inf_ti_items 
  ADD COLUMN kode VARCHAR(100) DEFAULT NULL;
