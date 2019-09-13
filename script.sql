create table Caroneiros (
	id bigserial UNIQUE PRIMARY KEY,
	chat_id bigint not null,
	user_id bigint not null,
	username varchar(128),
	travel_hour time,
	route bit,
	added timestamp default now()
);

