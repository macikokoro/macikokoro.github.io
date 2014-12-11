DROP TABLE IF EXISTS customer.categories;

ALTER TABLE customer.question_category DROP category,
    ADD category_id INT(11) not null,
    ADD FOREIGN KEY (question_id) REFERENCES customer.questions (id)
            ON DELETE CASCADE;

CREATE TABLE customer.categories (
    id INT(11) UNSIGNED NOT NULL auto_increment,
    name VARCHAR(255) NOT NULL,
    primary key (id),
    INDEX (name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
