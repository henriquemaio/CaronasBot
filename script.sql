create table Caroneiros(
	id bigserial UNIQUE PRIMARY KEY,
	chat_id int NOT NULL,
	user_id int NOT NULL,
	username varchar(128),
	location varchar(128),
	travel_hour time
);

alter table add route bit not null;
