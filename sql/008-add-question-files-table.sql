DROP TABLE IF EXISTS customer.question_files;

CREATE TABLE customer.question_files (
    id INT(11) UNSIGNED NOT NULL auto_increment,
    question_id INT(11) UNSIGNED NOT NULL,
    filename VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    foreign key (question_id) references customer.questions (id) on delete cascade
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
