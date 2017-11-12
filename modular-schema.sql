.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

CREATE TABLE User(
	user_id INTEGER PRIMARY KEY NOT NULL,
	username TEXT NOT NULL,
	f_name TEXT NOT NULL,
	l_name TEXT NOT NULL,
	birth_day INTEGER,
	birth_month INTEGER,
	birth_year INTEGER,
	bio TEXT,
	hashed_password TEXT
);

CREATE TABLE Model(
	model_id INTEGER PRIMARY KEY NOT NULL,
	creator_id INTEGER,
	material TEXT,
	cost TEXT,
	object_file TEXT,
	parent_id INTEGER,
	FOREIGN KEY creator_id REFERENCES User(user_id)  ON UPDATE cascade ON DELETE cascade
);