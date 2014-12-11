alter table customer.question_solutions drop solutions,
        add filename varchar(255) not null;
