ALTER TABLE customer.questions ADD title VARCHAR(255) NOT NULL, ADD level INT(2) NOT NULL DEFAULT 5;
ALTER TABLE customer.questions ADD INDEX (level);
