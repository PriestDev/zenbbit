-- Migration: add wallet address columns for additional assets
-- Run this SQL against your `zenbbit` database (e.g., via phpMyAdmin or mysql client)
ALTER TABLE `page_content`
  ADD COLUMN `bnb` VARCHAR(255) DEFAULT NULL,
  ADD COLUMN `sol` VARCHAR(255) DEFAULT NULL,
  ADD COLUMN `avax` VARCHAR(255) DEFAULT NULL;

-- Optional: verify columns
-- DESCRIBE page_content;
