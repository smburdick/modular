insert into User values (0,'sam','Sam','Burdick',25,4,1996,'tester',0,'sam@modular.com', NULL);
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
insert into Color values ("#FFFFFF", "white"), ("#FF0000", "red"), ("#00FF00", "green"), ("#0000FF", "blue"), ("#000000", "black");

/*
insert into Model values (0,0,0,100,'#FFFFFF',
	"g cube\n v  0.0  0.0  0.0\nv  0.0  0.0  1.0\nv  0.0  1.0  0.0\nv  0.0  1.0  1.0\nv  1.0  0.0  0.0\nv  1.0  0.0  1.0\nv  1.0  1.0  0.0\nv  1.0  1.0  1.0\nvn  0.0  0.0  1.0\nvn  0.0  0.0 -1.0\nvn  0.0  1.0  0.0\nvn  0.0 -1.0  0.0\nvn  1.0  0.0  0.0\nvn -1.0  0.0  0.0\nf  1//2  7//2  5//2\nf  1//2  3//2  7//2 \nf  1//6  4//6  3//6 \nf  1//6  2//6  4//6 \nf  3//3  8//3  7//3 \nf  3//3  4//3  8//3 \nf  5//5  7//5  8//5 \nf  5//5  8//5  6//5 \nf  1//4  5//4  6//4 \nf  1//4  6//4  2//4 \nf  2//1  6//1  8//1 \nf  2//1  8//1  4//1\n",
	NULL,
	'Cube'
);
*/
insert into User values (NULL,'jd','Jonh','Doe',0,0,0,'tester',0,'john@modular.com', NULL);

--insert into Model values (1,1,NULL,NULL,NULL,NULL,NULL,'test');

insert into Material values (
	NULL,
	'Plastic',
	10
);

insert into Material values (NULL, 'Glass', 15);


--insert into InCart values(0,0,4);