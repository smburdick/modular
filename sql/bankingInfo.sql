CREATE TABLE BankingInfo (
	banking_info_id INTEGER,
	user_id INTEGER,
	card_number INTEGER NOT NULL,
	ccv INTEGER NOT NULL,
	name_on_card TEXT NOT NULL,
	expiration_month INTEGER NOT NULL,
	expiration_year INTEGER NOT NULL,
	PRIMARY KEY (banking_info_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);