

CREATE TABLE Address(
	user_id INTEGER,
	address_id INTEGER PRIMARY KEY,
	address_line_one TEXT NOT NULL,
	address_line_two TEXT NOT NULL,
	city TEXT,
	state TEXT,
	zipcode INTEGER NOT NULL,
	country TEXT,
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);