create	table users (
	id SERIAL not null,
	username varchar(64) not null,
	email varchar (144) not null,
	password varchar(120) not null,
	first_name varchar (88) not null,
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
	company_name varchar (64) not null,
	email varchar (144) not null,
	password varchar(120) not null,
	first_name varchar (88) not null,
	last_name varchar (88) not null,
	date_of_birth varchar (45) not null,
	phone varchar (128) null,
	country varchar (64),
	company_url varchar (256) null,
	file_location varchar (256),
	joined timestamp default current_timestamp,
	profile_picture varchar(256) null,
	link varchar (512) null,
    session_id varchar(256) null,
	status varchar(64) null,
	primary key(id),
	unique(email)
);
create table category (
	id SERIAL,
	image varchar(256),
	name varchar (512),
	users_count integer,	
	creator integer not null,
	description varchar(960),	
	created timestamp default current_timestamp,
	primary key (id, image, name),
	foreign key (creator) references clients(id)
		on delete set null
);
create table network (
	id SERIAL,
	user_id integer,
	net_id integer,
    net_image varchar (256),
	net_name varchar (512),
    rank integer,
    score integer,
	primary key (id),
	foreign key (user_id) references users(id)
		on delete set null,
	foreign key (net_id, net_image, net_name) references category(id, image, name)
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

/*
drop table blacklist CASCADE;
drop table tokens CASCADE;
drop table sessions CASCADE;
drop table category CASCADE;
drop table network CASCADE;
drop table clients CASCADE;
drop table users CASCADE;
*/
