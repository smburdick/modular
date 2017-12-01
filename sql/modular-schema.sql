.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

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
);

CREATE TABLE Model(
	model_id INTEGER PRIMARY KEY,
	creator_id INTEGER,
	material_id INTEGER,
	mass_in_grams INTEGER,
	color_hex TEXT, -- hex value, e.g. "#FFFFFF"
	object_file GLOB,
	parent_id INTEGER,
	model_name TEXT,
	uploaded_date INTEGER,
	description TEXT,
	FOREIGN KEY (material_id) REFERENCES Material(material_id)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	FOREIGN KEY (creator_id) REFERENCES User(user_id) 
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	FOREIGN KEY (parent_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	FOREIGN KEY (color_hex) REFERENCES Color(hex)
		ON UPDATE CASCADE
		ON DELETE SET NULL
);

CREATE TABLE Material (
	material_id INTEGER PRIMARY KEY,
	material_name TEXT,
	cost_per_gram INTEGER NOT NULL
);

CREATE TABLE Color (
	hex TEXT PRIMARY KEY,
	name TEXT
);

/*
CREATE TABLE Created(
	model_id INTEGER,
	user_id INTEGER,
	creation_date TEXT,
	uploaded_date TEXT,
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY (model_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
*/

CREATE TABLE Review(
	user_id INTEGER,
	model_id INTEGER,
	review_date TEXT NOT NULL,
	review_title TEXT NOT NULL,
	comment TEXT NOT NULL,
	stars INTEGER CHECK (stars > 0 AND stars < 6),
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY (model_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE Bookmarks(
	user_id INTEGER,
	model_id INTEGER,
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY (model_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE Purchases(
	user_id INTEGER,
	model_id INTEGER,
	purchase_date TEXT,
	quantity INTEGER CHECK (quantity > 0),
	PRIMARY KEY (model_id, user_id, purchase_date),
	FOREIGN KEY (model_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE,
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE Address(
	user_id INTEGER,
	address_id INTEGER,
	address_line_one TEXT NOT NULL,
	address_line_two TEXT NOT NULL,
	city TEXT,
	state TEXT,
	zipcode INTEGER NOT NULL,
	country TEXT,
	PRIMARY KEY (user_id, address_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE BankingInfo (
	banking_info_id INTEGER,
	user_id INTEGER,
	card_number INTEGER NOT NULL,
	ccv INTEGER NOT NULL,
	billing_address_id INTEGER NOT NULL,
	name_on_card TEXT NOT NULL,
	PRIMARY KEY (banking_info_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (billing_address_id) REFERENCES Address(address_id)
		ON UPDATE CASCADE
		ON DELETE SET NULL
);

CREATE TABLE InCart(
	user_id INTEGER,
	model_id INTEGER,
	quantity INTEGER CHECK (quantity > 0),
	PRIMARY KEY (model_id, user_id),
	FOREIGN KEY (model_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE,
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE BelongsTo(
	model_id INTEGER,
	category_id INTEGER,
	PRIMARY KEY (model_id, category_id),
	FOREIGN KEY (model_id) REFERENCES Model(model_id)
		ON UPDATE CASCADE
	FOREIGN KEY (category_id) REFERENCES Category(category_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE Category(
	category_id INTEGER PRIMARY KEY,
	category_name TEXT NOT NULL,
	category_description TEXT
);
