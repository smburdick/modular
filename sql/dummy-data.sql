insert into Material values (
	0,
	'Gold',
	4149 -- price of gold in cents/grams
);
insert into Material values (
	NULL,
	'Silver',
	1713
);
insert into Material values (
	NULL,
	'Plastic',
	10
);

insert into Material values (NULL, 'Glass', 15);

insert into Color values ("#FFFFFF", "white"), ("#FF0000", "red"), ("#00FF00", "green"), ("#0000FF", "blue"), ("#000000", "black");

insert into Category values (NULL, 'None', 'Uncategorized'), (NULL, 'Shapes', 'Geometric solids.'), 
	(NULL, 'Miniatures', 'Small representations of real-world things'),
	(NULL, 'Airplanes', 'Miniature aircraft');