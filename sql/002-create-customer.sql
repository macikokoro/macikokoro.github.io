drop table if exists customer.company_salaries;
drop table if exists customer.companies_contact;
drop table if exists customer.companies;
drop table if exists customer.customer_likes_companies;
drop table if exists customer.customers;

create table customer.customers (
        id int(10) unsigned not null auto_increment
        ,email varchar(150) not null
        ,first_name varchar(50) null
        ,last_name varchar(50) null
        ,password_hash_1 varchar(150)
        ,profile_url varchar(1024)
        ,user_photo_url varchar(1024)
        ,type varchar(256)
        ,display_name varchar(256)
        ,city varchar(256)
        ,region varchar(256)
        ,zip varchar(256)
        ,address varchar(1024)
        ,created_at timestamp
        ,updated_at timestamp
        ,primary key (id)
        ,index(last_name)
        ,index(first_name)
        ,index(city)
        ,index (created_at)
        ,index (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

create table customer.customer_likes_companies (
  id int(10) unsigned not null auto_increment
  ,company_id int(10) not null
  ,customer_id int(10) not null
  ,created_at timestamp
  ,updated_at timestamp
  ,primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

create table customer.companies (
  id int(10) unsigned not null auto_increment
  ,company_name varchar(150) not null
  ,description varchar(1024) not null
  ,current_opening_count int(10)
  ,technology_stack varchar(1024) not null
  ,worklife_balance  int(10) unsigned not null
  ,bar     varchar(150) not null
  ,created_at timestamp
  ,updated_at timestamp
  ,primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

create table customer.companies_contact(
  id int(10) unsigned not null auto_increment,
  company_id int(10) unsigned not null,
  contact_name varchar(150) not null,
  contact_email varchar(150) not null
  ,created_at timestamp
  ,updated_at timestamp
  ,primary key (id)
  ,foreign key  (company_id) references   customer.companies (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


create table customer.company_salaries (
 id int(10) unsigned not null auto_increment,
 company_id int(10) unsigned not null,
 role varchar(150) not null,
 salary_start int(10) unsigned not null,
 salary_end   int(10) unsigned not null,
 primary key (id),
 foreign key  (company_id) references   customer.companies (id)
);
