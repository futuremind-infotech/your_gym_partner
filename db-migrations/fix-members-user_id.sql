-- Run this in phpMyAdmin or MySQL CLI to make `user_id` auto-increment primary key.
-- Backup your database first.

ALTER TABLE `members`
  MODIFY `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (`user_id`);

-- Verify with:
-- SHOW CREATE TABLE members;