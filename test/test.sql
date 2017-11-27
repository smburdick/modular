CREATE TABLE Model(
	model_id INTEGER,
	creator_id INTEGER,
	material TEXT,
	cost INTEGER,
	object_file TEXT,
	parent_id INTEGER,
	PRIMARY KEY(model_id),
	FOREIGN KEY creator_id REFERENCES User(user_id) 
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	);