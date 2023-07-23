Requires MySQL with database name "demo" and two tables


users for login with columns: 

ID int autoincrement primary key
username varchar(50) unique
password varchar(255)
timestamp datetime default current_timestamp
elevated int 

centers for search function

ID varchar(4 ) primary key
cname varchar(50) unique
city varchar(255)
slots int
address varchar(255)

booking for slot booking and history modules
ID int primary foreign key references login
fname varchar(15)
lname varchar(15)
age varchar(3 )
phone varchar(15)
center varchar(4 ) foreign key references centers


this table should also contain entries for searching to succeed 