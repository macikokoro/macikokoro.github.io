drop table if exists customer.users;
drop table if exists customer.user_groups;

create table customer.user_groups(
	id int(11) unsigned not null auto_increment,
	name varchar(255) not null,
	description varchar(255),
	primary key(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

insert into customer.user_groups (name, description) values
	('administrator', 'Users of this group has access to any part of the website'),
	('candidate', 'Candidate has access to candidate part of the website'),
	('evaluator', 'Evaluator group has access to evaluator part only');
