-- Add missing qr_code_path column to members table
ALTER TABLE members ADD COLUMN qr_code_path varchar(255) DEFAULT NULL;
