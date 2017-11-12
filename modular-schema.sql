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
	FOREIGN KEY creator_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);

CREATE TABLE Created(
	model_id INTEGER,
	user_id INTEGER,
	creation_date TEXT,
	uploaded_date TEXT,
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY model_id REFERENCES Model(model_id) ON UPDATE cascade ON DELETE cascade,
	FOREIGN KEY user_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);

CREATE TABLE Review(
	user_id INTEGER NOT NULL,
	model_id INTEGER NOT NULL,
	review_date TEXT NOT NULL,
	comment TEXT NOT NULL,
	stars TEXT NOT NULL,
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY model_id REFERENCES Model(model_id) ON UPDATE cascade ON DELETE cascade,
	FOREIGN KEY user_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);

CREATE TABLE Bookmarks(
	user_id INTEGER NOT NULL,
	model_id INTEGER NOT NULL,
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY model_id REFERENCES Model(model_id) ON UPDATE cascade ON DELETE cascade,
	FOREIGN KEY user_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);

CREATE TABLE Purchases(
	user_id INTEGER NOT NULL,
	model_id INTEGER NOT NULL,
	purchase_date TEXT NOT NULL,
	quantity INTEGER,
	PRIMARY KEY (model_id, user_id, purchase_date),
	FOREIGN KEY model_id REFERENCES Model(model_id) ON UPDATE cascade ON DELETE cascade,
	FOREIGN KEY user_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);

CREATE TABLE Address(
	user_id INTEGER NOT NULL,
	address_id TEXT NOT NULL,
	address_one TEXT,
	address_two TEXT,
	city TEXT,
	state TEXT,
	zipcode INTEGER,
	country TEXT,
	PRIMARY KEY (user_id, address_id),
	FOREIGN KEY user_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);

CREATE TABLE InCart(
	user_id INTEGER NOT NULL,
	model_id INTEGER NOT NULL,
	quantity INTEGER,
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY model_id REFERENCES Model(model_id) ON UPDATE cascade ON DELETE cascade,
	FOREIGN KEY user_id REFERENCES User(user_id) ON UPDATE cascade ON DELETE cascade
);
