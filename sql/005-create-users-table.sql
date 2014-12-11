drop table if exists customer.users;

create table customer.users (
	id int(11) unsigned not null auto_increment,
	email varchar(255) not null,
	first_name varchar(255) not null,
	last_name varchar(255) not null,
	password varchar(50) not null,
	profile_url varchar(255) not null default '',
	user_photo_url varchar(255) not null default '',
	type varchar(255) not null default '',
	user_group_id int(11) unsigned not null,
	display_name varchar(255) not null default '',
	city varchar(255) not null default '',
	region varchar(255) not null default '',
	zip varchar(255) not null default '',
	address varchar(1024) not null default '',
	created_at timestamp,
	updated_at timestamp,
	primary key (id),
	index (user_group_id),
	index (created_at),
	index (updated_at),
	foreign key  (user_group_id) references customer.user_groups (id) on delete cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

insert into customer.users (email, first_name, last_name, password, user_group_id)
    values ('igorbelykh86@gmail.com', 'Igor', 'Belykh', '25f9e794323b453885f5181f1b624d0b', 1);
