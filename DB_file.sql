create	table users (
	id SERIAL not null,
	username varchar(64) not null,
	email varchar (144) not null,
	password varchar(120) not null,
	first_name varchar (88) null,
	last_name varchar (88) null,
	date_of_birth varchar (45) null,
	phone varchar (128) null,
	country varchar (64),
	file_location varchar (256),
	joined timestamp default current_timestamp,
	profile_picture varchar(256) null,
	status varchar(64) null,
	link varchar (512) null,
    session_id varchar(256) null,
	primary key(id),
	unique (username),
	unique(email)
);
create	table clients (
	id SERIAL not null,
	first_name varchar (88) null,
	last_name varchar (88) null,
	email varchar (144) not null,
	password varchar(120) not null,
	date_of_birth varchar (45) null,
	phone varchar (128) null,
	company_name varchar (256) not null,
	company_url varchar (256) not null,
	file_location varchar (256),
	joined timestamp default current_timestamp,
	profile_picture varchar(256) null,
	link varchar (512) null,
    session_id varchar(256) null,
	status varchar(64) null,
	primary key(id),
	unique(email)
);

create table network (
	id SERIAL,
	user_id integer,
	following_id integer,
	primary key (id),
	foreign key (user_id) references users(id)
		on delete set null,
	foreign key (following_id) references users(id)
		on delete set null
);	
create table category (
	id SERIAL,
	name varchar (512) not null,
	image varchar(256),
	users_count integer,	
	creator integer not null,
	description varchar(960),	
	created timestamp default current_timestamp,
	primary key (id),
	foreign key (creator) references clients(id)
		on delete set null
);
create table sessions (
	id SERIAL,
	user_id integer,
	ip_address varchar(44),
	device_name varchar(88),
	foreign key (user_id) references users(id)
		on delete set null
);
create table tokens (
	id SERIAL,
	client_id integer,
	valid date,
	request_count integer,
	foreign key (client_id) references clients(id)
		on delete set null
);
create table blacklist (
	id SERIAL,
	ip varchar (15)	
);


drop table blacklist CASCADE;
drop table tokens CASCADE;
drop table sessions CASCADE;
drop table category CASCADE;
drop table network CASCADE;
drop table clients CASCADE;
drop table users CASCADE;
