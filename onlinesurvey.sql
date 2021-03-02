create database if not exists onlinesurvey;
use onlinesurvey;

create table if not exists users(
    id int primary key auto_increment,
    name varchar(50) not null,
    email varchar(50) unique not null,
    password varchar(255) not null,
    user_img varchar(255) default 'dummy.png',
    created_at datetime default now()
);

create table if not exists question_forms(
	id int primary key auto_increment,
    title varchar(50),
    slug varchar(50),
    user_id int not null,
    created_at datetime default now(),
    uuid varchar(50) unique default replace(uuid() , '-' , ''),
    survey_img varchar(255) default 'noimage.png',
    constraint foreign key(user_id) references users(id) on delete cascade
);

create table if not exists answer_forms(
	id int primary key auto_increment,
	question_form_id int not null,
    created_at datetime default now(),
    seen tinyint default 0,
    country varchar(255),
    city varchar(255),
    lat float(10,6),
    lon float(10,6),
    constraint foreign key(question_form_id) references question_forms(id) on delete cascade
);

create table if not exists questions(
	id int primary key auto_increment,
	type varchar(20) not null,
    required tinyint not null,
    body varchar(255) not null,
    question_form_id int not null,
    constraint foreign key(question_form_id) references question_forms(id) on delete cascade
);

create table if not exists propositions(
	id int primary key auto_increment,
    body varchar(255) not null,
    question_id int not null,
    constraint foreign key(question_id) references questions(id) on delete cascade
);

create table if not exists answers(
	id int primary key auto_increment,
    answer_form_id int not null,
    question_id int not null,
    constraint foreign key(answer_form_id) references answer_forms(id) on delete cascade,
	constraint foreign key(question_id) references questions(id) on delete cascade
);

create table if not exists mcq(
    id int primary key,
    body varchar(255)
);

create table if not exists open(
    id int primary key,
    body text
);
create table if not exists date(
    id int primary key,
    body date
);
create table if not exists time(
    id int primary key,
    body time
);
create table if not exists minmax(
    id int primary key,
    minimum int,
    maximum int
);

create table if not exists password_resets(
	id int primary key auto_increment,
	email varchar(50) unique not null,
    token varchar(255) not null,
    expires timestamp default current_timestamp
);