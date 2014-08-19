CREATE TABLE users(
	id int(100) primary key auto_increment,
	fname text,
	lname text,
	email text not null,
	password text not null
);

CREATE TABLE proposal_types(
	id int(100) primary key auto_increment,
	type text not null
);

CREATE TABLE company_details (
	id int(100) primary key AUTO_INCREMENT,
	legal_name text,
	trading_name text,
	head_office text,
	postal_address text,
	telephone_no text,
	fac_no text,
	web text,
	primary_contact text,
	acn text,
	abn text,
	poc_email text,
	mobile_no text,
	proposal_id int(100) not null,
	FOREIGN KEY(proposal_id) REFERENCES proposals(id)
)

CREATE TABLE proposals(
	id int(100) primary key auto_increment,
	title text not null,
	client_name text not null,
	submission_date date,
	company_overview text,
	confirmation_of_requirements text,
	scope_of_works text,
	company_estimate text,
	conclusion text,
	date_modified date,
	date_created timestamp default CURRENT_TIMESTAMP,
	status varchar(250) default 'Draft',
	proposal_type_id int(100) not null,
	user_id int(100) not null,
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(proposal_type_id) REFERENCES proposal_types(id)
);

CREATE TABLE images(
	id int(100) primary key auto_increment,
	name text not null,
	image text not null,
	proposal_id int(100) not null,
	FOREIGN KEY(proposal_id) REFERENCES proposals(id)
);