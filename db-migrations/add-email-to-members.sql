-- Add email column to members table
-- Migration Date: 2026-02-13

ALTER TABLE members ADD COLUMN email VARCHAR(255) DEFAULT NULL AFTER contact;

-- Update existing records to have placeholder emails (can be updated later)
-- This ensures the column exists for new functionality
