/*INSERT INTO Category VALUES (
	1,
	"fun",
	"just a whole lotta fun stuff my dude"
	);

INSERT INTO Category VALUES (
	2,
	"bun",
	"just a whole lotta bun stuff my dude"
	);

INSERT INTO Category VALUES (
	3,
	"run",
	"just a whole lotta run stuff my dude"
	);

INSERT INTO Category VALUES (
	4,
	"shun",
	"just a whole lotta shun stuff my dude"
	);

INSERT INTO Category VALUES (
	5,
	"pun",
	"just a whole lotta pun stuff my dude"
	);

INSERT INTO Category VALUES (
	6,
	"hun",
	"just a whole lotta hun stuff my dude"
	);

*/
/*CREATE TABLE Material (
	material_id INTEGER PRIMARY KEY,
	material_name TEXT,
	cost_per_gram INTEGER NOT NULL
);

CREATE TABLE Color (
	hex TEXT PRIMARY KEY,
	name TEXT
);


CREATE TABLE User(
	user_id INTEGER PRIMARY KEY,
	username TEXT NOT NULL UNIQUE,
	f_name TEXT NOT NULL,
	l_name TEXT NOT NULL,
	birth_day INTEGER,
	birth_month INTEGER,
	birth_year INTEGER,
	bio TEXT,
	hashed_password INTEGER,
	email TEXT,
	photo BLOB
);*/

/*
insert into Material values (0, "wood", 999);
insert into Color values ('#FFFFFF', 'white');
insert into User values (0, "ian", "ian", "white", null ,null, null, null, null, null, null);
insert into Model values (0,0,0,100,'#FFFFFF', null, 0, "cube", 0);
INSERT INTO Category VALUES (
	0,
	"zun",
	"just a whole lotta zun stuff my dude"
	);
insert into belongsto values (0, 0);

insert into User values (1, "bill", "bill", "chill", null ,null, null, null, null, null, null);
insert into User values (2, "douglas", "douglas", "mcarthur", null ,null, null, null, null, null, null);
insert into User values (3, "tim", "tim", "heidecker", null ,null, null, null, null, null, null);

insert into Material values (1, "metal", 37);
insert into Material values (2, "plastic", 97);
insert into Material values (3, "water", 9);

insert into Model values (1,1,1,100,'#FFFFFF', null, 0, "ship", 0);
insert into Model values (2,2,2,100,'#FFFFFF', null, 0, "skateboard", 0);
insert into Model values (3,3,3,100,'#FFFFFF', null, 0, "chair", 0);

insert into belongsto values (1, 1);
insert into belongsto values (2, 2);
insert into belongsto values (3, 3);*/

/*insert into belongsto values (4, 1);
insert into belongsto values (5, 2);
insert into belongsto values (6, 3);*/

insert into belongsto values (7, 1);
insert into belongsto values (8, 2);
insert into belongsto values (9, 3);

/*insert into Model values (4,1,1,100,'#FFFFFF', null, 0, "ship", 0);
insert into Model values (5,2,2,100,'#FFFFFF', null, 0, "skateboard", 0);
insert into Model values (6,3,3,100,'#FFFFFF', null, 0, "chair", 0);*/

insert into Model values (7,1,1,100,'#FFFFFF', null, 0, "building", 0);
insert into Model values (8,2,2,100,'#FFFFFF', null, 0, "car", 0);
insert into Model values (9,3,3,100,'#FFFFFF', null, 0, "table", 0);