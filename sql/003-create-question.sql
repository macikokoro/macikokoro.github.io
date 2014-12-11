drop table if exists customer.question_solutions;
drop table if exists customer.question_hints;
drop table if exists customer.question_category;
drop table if exists customer.question_categories;
drop table if exists customer.question_files;
drop table if exists customer.customer;
drop table if exists customer.questions;
create table customer.questions (
        id int(10) unsigned not null auto_increment
        ,question_id varchar(1024) not null
        ,description varchar(1024) not null
        ,directory varchar(1024)
        ,junit_directory varchar(1024)
        ,repository_url varchar(1024)
        ,file_name varchar(1024)
        ,language  varchar(1024)
        ,prop varchar (10240)
        ,created_at timestamp
        ,updated_at timestamp
        ,primary key (id)
        ,index (created_at)
        ,index (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

create table customer.question_category(
  id int(10) unsigned not null auto_increment,
  question_id  int(10) unsigned not null,
  primary key (id),
  category varchar(1024)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

create table customer.question_hints(
  id int(10) unsigned not null auto_increment,
  question_id  int(10) unsigned not null,
  hint varchar(1024)
  ,primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

create table customer.question_solutions(
  id int(10) unsigned not null auto_increment,
  question_id  int(10) unsigned not null,
  solutions varchar(1024)
  ,primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
