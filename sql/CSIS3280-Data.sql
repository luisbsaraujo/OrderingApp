USE csis3280bcc;

DELETE FROM orders;
DELETE FROM item;
DELETE FROM customer;

INSERT INTO item (description, price) VALUES 
('Cactus Pads',23.58),
('Cheese - Brie',16.42),
('Bagel - Whole White Sesame',34.33),
('Wanton Wrap',19.58),
('Pepper - Paprika',47.45),
('Chocolate - White',29.49),
('Smoked Back Bacon',34.03),
('Chocolate - Dark',14.74),
('Nougat - Cream',27.46),
('Shrimp - Baby',39.87),
('Pasta - Lasagna',34.30),
('Clams - Canned',26.79),
('Butter - Unsalted',17.27),
('Ham - Cooked Italian',24.57),
('Daikon Radish',27.79);


INSERT INTO customer (first_name, last_name, email, phone) VALUES 
('Thebault', 'Pevsner', 'tpevsner0@java.com', '955-830-8748'),
('Esta', 'Jerome', 'ejerome1@multiply.com', '967-417-3490'),
('Holt', 'Adams', 'hadams2@uiuc.edu', '220-759-6370'),
('Claudie', 'Wethered', 'cwethered3@jalbum.net', '729-298-2756'),
('Eamon', 'Ephgrave', 'eephgrave4@chron.com', '647-839-5388'),
('Cammy', 'Stolte', 'cstolte5@alibaba.com', '622-342-9365'),
('Lev', 'Hatfull', 'lhatfull6@un.org', '405-272-8318'),
('Kristine', 'Boase', 'kboase7@nhs.uk', '533-734-7695'),
('Leila', 'Meert', 'lmeert8@networkadvertising.org', '418-765-3981'),
('Dennison', 'Limming', 'dlimming9@skyrock.com', '485-117-7259'),
('John', 'Gildea', 'qgildeaa@apache.org', '759-920-4462'),
('Yetty', 'Ife', 'yifeb@nature.com', '502-129-4426'),
('Kelby', 'Sprake', 'ksprakec@nature.com', '716-817-9723'),
('Rory', 'Dechelette', 'rdecheletted@mediafire.com', '293-298-0734'),
('Waylan', 'Knowlman', 'wknowlmane@google.co.uk', '395-246-1020');


drop procedure if exists sp_createOrders;
  
DELIMITER //
create procedure sp_createOrders()
begin
  declare n int;
  declare m int;
  declare s int;
  declare numIt int;
  declare oId int;
  declare qtd int;
  declare cId int;
  declare iId int;
  declare rndId int;
  
  select min(customerid) into cId from customer;
  select min(itemId)     into iId from item;
  
  delete from orders;
  
  /* n customers */
  set n:=0;
  set oId:=1;
  while n <15 do
    set oId := oId+1;
    /* numIt itens 1 to 10 */
	set numIt:= floor(rand()*10+1);
    set m:=0;
	while m < numIt do
	    /* pick one item */
		set s:= 1;
		while s > 0 do
			set rndId := floor(rand()*16+iId);
			select count(1) into s from orders where orderId = oId and itemId = rndId;
		end while;
		/* pick qtd 1 to 3*/
		set qtd = floor(rand()*3+5);
		insert into orders (orderId, customerId, itemId, qtty, total) 
		  select oId, n+cId as customerId, rndId, qtd, qtd * i.price as total
		    from item i
		   where i.itemId = rndId;
		set m := m+1;
		if floor(rand()*11) > 6 then 
		  set oId := oId + 1;
		end if;
	end while;
    set n := n+1;
  end while;
end//

DELIMITER ;

call sp_createOrders;

