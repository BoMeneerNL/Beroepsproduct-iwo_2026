
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON pizzeria.* TO 'user'@'%';
FLUSH PRIVILEGES;

CREATE TABLE `User` (
  username VARCHAR(255) PRIMARY KEY,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  address VARCHAR(255),
  role VARCHAR(50) NOT NULL
);

CREATE TABLE ProductType (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Ingredient (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Product (
  name VARCHAR(255) PRIMARY KEY,
  price DECIMAL(10,2) NOT NULL,
  type_id VARCHAR(255) NOT NULL,
  image_link VARCHAR(255),
  FOREIGN KEY (type_id) REFERENCES ProductType(name)
);

CREATE TABLE Product_Ingredient (
  product_name VARCHAR(255),
  ingredient_name VARCHAR(255),
  PRIMARY KEY (product_name, ingredient_name),
  FOREIGN KEY (product_name) REFERENCES Product(name),
  FOREIGN KEY (ingredient_name) REFERENCES Ingredient(name)
);

CREATE TABLE Pizza_Order (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  client_username VARCHAR(255),
  client_name VARCHAR(255) NOT NULL,
  personnel_username VARCHAR(255) NOT NULL,
  datetime DATETIME NOT NULL,
  status INT,
  address VARCHAR(255),
  FOREIGN KEY (client_username) REFERENCES `User`(username),
  FOREIGN KEY (personnel_username) REFERENCES `User`(username)
);

CREATE TABLE Pizza_Order_Product (
  order_id INT,
  product_name VARCHAR(255),
  quantity INT NOT NULL,
  PRIMARY KEY (order_id, product_name),
  FOREIGN KEY (order_id) REFERENCES Pizza_Order(order_id),
  FOREIGN KEY (product_name) REFERENCES Product(name)
);


INSERT INTO `User` (`username`, `password`, `first_name`, `last_name`,`address`, `role`) VALUES
        ('abrouwer', '$argon2id$v=19$m=65536,t=4,p=1$YlFDWWZFcEdrM08vNWc1Rg$wlPnXec5LuNAQsGLFOuric6hLvNi6PH8tNCJvLb/Rxc', 'Anna', 'Brouwer', null, 'Personnel'),
        ('adekhane', '$argon2id$v=19$m=65536,t=4,p=1$ZGlaeXJ3MTBMdkxmeEcuRA$0wTo5W+ZEGeNWglA+OwnJY32bPrpRm3vNvN8aVj48PM', 'Ahmed', 'Dekhane', null, 'Client'),
        ('aghebre', '$argon2id$v=19$m=65536,t=4,p=1$LklNVEpYMFpNQk5OMUFTSw$B8QokQTsiFOu7BcWkTjZ3Xr1sU6w4zaUAO1r/CDDq6Q', 'Amanuel', 'Ghebre', null, 'Client'),
        ('aivanov', '$argon2id$v=19$m=65536,t=4,p=1$d240ZUZRdDVWYko5OHNZNQ$BBVSP6HRo5HlpFmoQ4KfYUaF3TER6xoLJddf7G6aXDY', 'Alexei', 'Ivanov', null, 'Personnel'),
        ('ayildiz', '$argon2id$v=19$m=65536,t=4,p=1$V3FWVWp0Z2JuMERsT1FNUA$1TK9nCC/Y9TDs/B3dslSu9HX20FDVSddMzf0KJ3+6js', 'Aylin', 'Yildiz', null, 'Personnel'),
        ('dpetrov', '$argon2id$v=19$m=65536,t=4,p=1$Lm5Bb011ZEk5dzl6VVlTWQ$EtU5MYAbs6vFTkCJuBrKoBCa4Ay9XlQJxlKQr5F8eHQ', 'Dmitri', 'Petrov', null, 'Personnel'),
        ('dschouten', '$argon2id$v=19$m=65536,t=4,p=1$WUY3WVZHS1FRd3F3LlZZaw$rhHIxAsg0U25whaQmBRdstZpgBunTa8gusE+QDTywJo', 'David', 'Schouten', null, 'Client'),
        ('evisscher', '$argon2id$v=19$m=65536,t=4,p=1$Nkd1NnhKSHp0dHFpZGcxWA$P9j/hzyrQlqK19prdJtnim7u8AwZceyRKH6ays672RU', 'Emma', 'Visscher', null, 'Client'),
        ('fholwerda', '$argon2id$v=19$m=65536,t=4,p=1$WUhidlUwUm4xaHJlUmRsSg$T1V4y4aG1T4eHNV1e/eH4EhchUHHPqJBsAayyaEY/eo', 'Fenna', 'Holwerda', null, 'Client'),
        ('gkoolstra', '$argon2id$v=19$m=65536,t=4,p=1$Mmk5cEkzWGFsZHJkNXJUcw$+2hZUTrClKNOo/OgkYfWCbro+S5NjRWCJWo2UX466ow', 'Gert', 'Koolstra', null, 'Client'),
        ('hdeleeuw', '$argon2id$v=19$m=65536,t=4,p=1$U2FLMDhERzB6SDdnNHUzRg$awcZEzcVbjyg6B8uHVf6EFypcAMuPnyGIjscXKcx34I', 'Hanna', 'de Leeuw', null, 'Client'),
        ('hradman', '$argon2id$v=19$m=65536,t=4,p=1$Q1lyNERZSngyR2JtdXRQSw$/OrmHv+zRTU+FlWC/hFQZG8R3mweQRQt2A1aLDfwD8I', 'Hassan', 'Radman', null, 'Client'),
        ('ibrahimovic', '$argon2id$v=19$m=65536,t=4,p=1$QVppTzQ1b1VYdUp3OGdsSw$TAckXiBgd40fMKQDfsZzJJ+bBEaCOXDfVW9rLC3W7d8', 'Ismail', 'Brahimovic', null, 'Client'),
        ('jdoe', '$argon2id$v=19$m=65536,t=4,p=1$UnNyL0lTcmR6eXVmZEwwLg$RhZDwzN7ySspp3p66zBbta8Vo3p2vElcMka2BKQDvVw', 'John', 'Doe', null, 'Client'),
        ('kdijkstra', '$argon2id$v=19$m=65536,t=4,p=1$dnhPd2FhSlo1eTcydTZqRg$lf/voYu2YjjDkxNcQKIVI4dT1/eVHLYj3dNZ0frmeFk', 'Klaas', 'Dijkstra', null, 'Client'),
        ('lbaloyi', '$argon2id$v=19$m=65536,t=4,p=1$WFBLZkltNzN6bi5LNmYyZw$aaMTF6P+DcTdmjp3YSNpCZt8lg+d73YBd4pdkJVCa7M', 'Lerato', 'Baloyi', null, 'Personnel'),
        ('lheineken', '$argon2id$v=19$m=65536,t=4,p=1$Q3QxUEN1RC5NVXdZSU1SOQ$EC6La/JFf+DAUZQYbsP3lvtD1r2QvseDghCFngC1OlE', 'Lucas', 'Heineken', null, 'Personnel'),
        ('lsaleh', '$argon2id$v=19$m=65536,t=4,p=1$U2tnM2dwTS5ZMS9PazA4MQ$WDj9EQFGWNHFgd5ctbNThqcxhgP9Ono4Wq7efUXU9gU', 'Lina', 'Saleh', null, 'Personnel'),
        ('mbouaziz', '$argon2id$v=19$m=65536,t=4,p=1$VUpicy5XMVprb216RmdwcA$3Nje+Gk4/yuyVrPGt9vN6uXqMPdcGjxx2jV19267szU', 'Mouna', 'Bouaziz', null, 'Client'),
        ('mkarimi', '$argon2id$v=19$m=65536,t=4,p=1$d0NJcFZCM1owRlhTelNnYQ$uBK1ayPh8N+ZzIxjg9kECwb9iSmACgMs04HF5BW+jKU', 'Mina', 'Karimi', null, 'Client'),
        ('mkassem', '$argon2id$v=19$m=65536,t=4,p=1$S0M4TVFRWWJaY1hqTVZXSw$uML6WOdchCxXmjeISpXvhof/WppzDD9ZacBKjYJfv7o', 'Mohammed', 'Kassem', null, 'Personnel'),
        ('mnijland', '$argon2id$v=19$m=65536,t=4,p=1$bmFvOUFIYnpja05aYU94QQ$SJS2yAPvMyh/EEaWleBnk3SFyP5NYF80+jKnV/NHTD8', 'Maud', 'Nijland', null, 'Personnel'),
        ('mtsega', '$argon2id$v=19$m=65536,t=4,p=1$N0FHb0Fwa1YzdG0ydXo1cA$FySM0JLggkOAJdT2kMWvs4ZvPpIYk9Ope9EWvPDXKww', 'Miriam', 'Tsega', null, 'Client'),
        ('mvandam', '$argon2id$v=19$m=65536,t=4,p=1$cDV3eEp4b2l6elZNYU5iOA$NZBOA8pIAoTuFmCxtc6h0zLgpSwcqqGJ/ThdBMlWNJg', 'Mila', 'van Dam', null, 'Personnel'),
        ('mvermeer', '$argon2id$v=19$m=65536,t=4,p=1$SXFlTHE1SHZGN3YyOGxsbA$cZsLgv7v/GvYNgHrV1J0fP0RLdnTN+McbXy3k+R/1po', 'Maria', 'Vermeer', null, 'Client'),
        ('ngebre', '$argon2id$v=19$m=65536,t=4,p=1$VEt3UHgwZklxaHJYa3hkRA$e1fNB7xd/31yaQCZINGBuSK+EyF4X98VDj6e9dCk6gw', 'Nardos', 'Gebre', null, 'Personnel'),
        ('pkowalski', '$argon2id$v=19$m=65536,t=4,p=1$aGhLaXBIWmZBYUJuTHBQeA$OIVpgt+wzJPVInmW46x7d8pObs+rC2KAPKjiY9tKaUA', 'Piotr', 'Kowalski', null, 'Personnel'),
        ('pvanveen', '$argon2id$v=19$m=65536,t=4,p=1$M0xqT1hMZldzUFJYMXF6ag$jVrpTp32GKeoOJtpN8zKyDKZ4FO8hFIgSlLCnImw9YE', 'Peter', 'van Veen', null, 'Personnel'),
        ('rdeboer', '$argon2id$v=19$m=65536,t=4,p=1$V2hXTU9sRHZiV2VhLm9tdg$WSfSscM3FSl9F3g8DhrgKdyTepu/xH+l8geGlWsnPes', 'Rik', 'de Boer', null, 'Personnel'),
        ('rkramer', '$argon2id$v=19$m=65536,t=4,p=1$YzAvLlhEVnpvQTZCdExvZg$MgjaR18UHKbI0YxbR/ZY1QPpCu/93U5JCn4CsUCA7hc', 'Rob', 'Kramer', null, 'Personnel'),
        ('rnarsingh', '$argon2id$v=19$m=65536,t=4,p=1$Zjl2S3pNNW5IUExEOHJheA$mZShuoR3csGMu4H8dfCjEnHb2t0+xeEe0jqVRWuhTOU', 'Rajesh', 'Narsingh', null, 'Client'),
        ('sbakker', '$argon2id$v=19$m=65536,t=4,p=1$U3BOUlIveklrTGRnV2h6Mw$1v9S8pJzWBJL7/CBx2lyTaRZ8DoCFzMd/TZ2baZ7Bec', 'Sophie', 'Bakker', null, 'Personnel'),
        ('sdurga', '$argon2id$v=19$m=65536,t=4,p=1$Q2QyYXRCOG5GTUNOdkF4VA$GPGyJwH+KlyHjU8BQT7HQR+U/kjw2FZPaV063eXf/o4', 'Shanti', 'Durga', null, 'Client'),
        ('snovak', '$argon2id$v=19$m=65536,t=4,p=1$eXBteEU5M3B4eWpBMGFUbg$VU0VDoG3wJiXTJIVyfi45ixr+yZgEXMlUUFxp2HkNKs', 'Sanja', 'Novak', null, 'Client'),
        ('tbayrak', '$argon2id$v=19$m=65536,t=4,p=1$MDhiTk5FVTlhQ01yQVdjZA$bJerg//kSzCZIUT0c5OhqzTDs6undxRDZd+yhlNFSro', 'Tarik', 'Bayrak', null, 'Personnel'),
        ('tjanssen', '$argon2id$v=19$m=65536,t=4,p=1$NDVRc084b0JtRWlKRFljaw$WfAvxO+7x+KSzfcZ753SuewEJ+cS5HTdAEFeKC9sSjI', 'Tom', 'Janssen', null, 'Personnel'),
        ('tvandermeer', '$argon2id$v=19$m=65536,t=4,p=1$SXg1eVBma0xEVktrM24vLg$3iNYY48Yfe3S4JOmxKQRtJc+VgXXU4BYB2Qv74YugWc', 'Tessa', 'van der Meer', null, 'Client'),
        ('wbos', '$argon2id$v=19$m=65536,t=4,p=1$QnRHQ0Z2MFVWSWJkYVl6Vw$6PiCshEtG3c47+4Nbjl80RvzuxE9cW4ZkiVu54Xgc5E', 'Willem', 'Bos', null, 'Client'),
        ('yabebe', '$argon2id$v=19$m=65536,t=4,p=1$emJ4ZHRLR0hCUDVuSHpDcw$tYFP12Neaa8tTas/fb70Zr6u54PjK5d95lLKsy9sVh8', 'Yonas', 'Abebe', null, 'Personnel');

INSERT INTO ProductType (`name`) VALUES
('Pizza'),
('Maaltijd'),
('Specerij'),
('Voorgerecht'),
('Drinken');

INSERT INTO Ingredient (`name`) VALUES
('Tomaat'),
('Kaas'),
('Pepperoni'),
('Champignon'),
('Ui'),
('Sla'),
('Spek'),
('Saus');

INSERT INTO Product (name, price, type_id,image_link) VALUES
('Margherita Pizza', 9.99, 'Pizza',null),
('Pepperoni Pizza', 11.99, 'Pizza',null),
('Vegetarische Pizza', 10.99, 'Pizza',null),
('Hawaiian Pizza', 12.99, 'Pizza',null),
('Combinatiemaaltijd', 15.99, 'Maaltijd',null),
('Knoflookbrood', 4.99, 'Voorgerecht',null),
('Coca Cola', 2.49, 'Drinken',null),
('Sprite', 2.49, 'Drinken',null);

INSERT INTO Product_Ingredient (product_name, ingredient_name) VALUES
('Margherita Pizza', 'Tomaat'),
('Margherita Pizza', 'Kaas'),
('Pepperoni Pizza', 'Tomaat'),
('Pepperoni Pizza', 'Kaas'),
('Pepperoni Pizza', 'Pepperoni'),
('Vegetarische Pizza', 'Tomaat'),
('Vegetarische Pizza', 'Kaas'),
('Vegetarische Pizza', 'Champignon'),
('Vegetarische Pizza', 'Ui'),
('Hawaiian Pizza', 'Tomaat'),
('Hawaiian Pizza', 'Kaas'),
('Hawaiian Pizza', 'Pepperoni'),
('Hawaiian Pizza', 'Ui'),
('Hawaiian Pizza', 'Sla'),
('Hawaiian Pizza', 'Spek'),
('Hawaiian Pizza', 'Saus'),
('Combinatiemaaltijd', 'Tomaat'),
('Combinatiemaaltijd', 'Kaas'),
('Combinatiemaaltijd', 'Pepperoni'),
('Combinatiemaaltijd', 'Champignon'),
('Combinatiemaaltijd', 'Ui'),
('Combinatiemaaltijd', 'Sla'),
('Combinatiemaaltijd', 'Spek'),
('Combinatiemaaltijd', 'Saus');

INSERT INTO `Pizza_Order` (client_username, client_name, personnel_username, datetime, status, address) VALUES
('jdoe', 'John Doe', 'rdeboer', '2024-06-12 18:45:00', 1, 'Bakkerstraat 1, 6811EG, Arnhem'),
('mvermeer', 'Maria Vermeer', 'sbakker', '2024-06-12 19:00:00', 2, 'Jansplein 2, 6811GD, Arnhem'),
('fholwerda', 'Fenna Holwerda', 'lheineken', '2024-06-12 19:15:00', 1, 'Willemsplein 3, 6811KD, Arnhem'),
('kdijkstra', 'Klaas Dijkstra', 'mvandam', '2024-06-12 19:30:00', 2, 'Kerkstraat 4, 6811DW, Arnhem'),
('gkoolstra', 'Gert Koolstra', 'tjanssen', '2024-06-12 19:45:00', 3, 'Rijnkade 5, 6811HA, Arnhem'),
(NULL, 'Pieter Post', 'abrouwer', '2024-06-12 20:00:00', 1, 'Grote Markt 6, 6511KB, Nijmegen'),
(NULL, 'Anna Smits', 'wbos', '2024-06-12 20:15:00', 2, 'Sint Annastraat 7, 6524EZ, Nijmegen'),
(NULL, 'Bert van Dijk', 'tvandermeer', '2024-06-12 20:30:00', 3, 'Oranjesingel 8, 6511NV, Nijmegen'),
(NULL, 'Sara de Vries', 'rkramer', '2024-06-12 20:45:00', 1, 'Van Welderenstraat 9, 6511MS, Nijmegen'),
(NULL, 'Jan Jansen', 'mnijland', '2024-06-12 21:00:00', 2, 'Molenstraat 10, 6511HJ, Nijmegen'),
('dschouten', 'David Schouten', 'hdeleeuw', '2024-06-13 18:45:00', 1, 'Velperweg 11, 6814AD, Arnhem'),
('evisscher', 'Emma Visscher', 'pvanveen', '2024-06-13 19:00:00', 2, 'Geitenkamp 12, 6815AP, Arnhem'),
('adekhane', 'Ahmed Dekhane', 'ayildiz', '2024-06-13 19:15:00', 1, 'IJssellaan 13, 6821DJ, Arnhem'),
('wbos', 'Willem Bos', 'tbayrak', '2024-06-13 19:30:00', 2, 'Broekstraat 14, 6822GD, Arnhem'),
('mnijland', 'Maud Nijland', 'mkassem', '2024-06-13 19:45:00', 3, 'Apeldoornsestraat 15, 6828AJ, Arnhem'),
(NULL, 'Els de Boer', 'lsaleh', '2024-06-13 20:00:00', 1, 'Marialaan 16, 6541RP, Nijmegen'),
(NULL, 'Tom Bakker', 'pkowalski', '2024-06-13 20:15:00', 2, 'Smetiusstraat 17, 6511EP, Nijmegen'),
(NULL, 'Mila Janssen', 'aivanov', '2024-06-13 20:30:00', 3, 'Van Oldenbarneveltstraat 18, 6511PA, Nijmegen'),
(NULL, 'Lars de Groot', 'mkarimi', '2024-06-13 20:45:00', 1, 'Hertogstraat 19, 6511RV, Nijmegen'),
(NULL, 'Rik Kramer', 'dpetrov', '2024-06-13 21:00:00', 2, 'Van Schaeck Mathonsingel 20, 6512AP, Nijmegen'),
(NULL, 'Sophie van der Meer', 'ibrahimovic', '2024-06-14 18:45:00', 1, 'Lange Hezelstraat 21, 6511CM, Nijmegen'),
('rdeboer', 'Rik de Boer', 'sbakker', '2024-06-14 19:00:00', 2, 'Waalkade 22, 6511XR, Nijmegen'),
('mvermeer', 'Maria Vermeer', 'lheineken', '2024-06-14 19:15:00', 1, 'Sint Jacobslaan 23, 6533BT, Nijmegen'),
('jdoe', 'John Doe', 'mvandam', '2024-06-14 19:30:00', 2, 'Van Broeckhuysenstraat 24, 6511PE, Nijmegen'),
(NULL, 'Henk de Wit', 'gkoolstra', '2024-06-14 19:45:00', 3, 'Ziekerstraat 25, 6511LH, Nijmegen');

INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) VALUES
(1, 'Margherita Pizza', 2),
(1, 'Coca Cola', 3),
(2, 'Pepperoni Pizza', 1),
(2, 'Sprite', 2),
(3, 'Vegetarische Pizza', 1),
(3, 'Hawaiian Pizza', 1),
(4, 'Combinatiemaaltijd', 2),
(4, 'Knoflookbrood', 1),
(5, 'Pepperoni Pizza', 1),
(6, 'Margherita Pizza', 3),
(6, 'Hawaiian Pizza', 2),
(7, 'Combinatiemaaltijd', 2),
(8, 'Knoflookbrood', 2),
(8, 'Sprite', 1),
(9, 'Pepperoni Pizza', 1),
(10, 'Hawaiian Pizza', 2),
(10, 'Coca Cola', 2),
(11, 'Margherita Pizza', 2),
(12, 'Vegetarische Pizza', 1),
(13, 'Hawaiian Pizza', 3),
(13, 'Coca Cola', 1),
(14, 'Combinatiemaaltijd', 1),
(14, 'Knoflookbrood', 1),
(15, 'Pepperoni Pizza', 2),
(15, 'Sprite', 2),
(16, 'Margherita Pizza', 1),
(17, 'Vegetarische Pizza', 2),
(18, 'Hawaiian Pizza', 1),
(19, 'Combinatiemaaltijd', 2),
(19, 'Knoflookbrood', 1),
(20, 'Pepperoni Pizza', 3),
(21, 'Hawaiian Pizza', 2),
(21, 'Coca Cola', 1),
(22, 'Margherita Pizza', 2),
(22, 'Knoflookbrood', 1),
(23, 'Pepperoni Pizza', 1),
(24, 'Vegetarische Pizza', 2),
(25, 'Hawaiian Pizza', 2),
(25, 'Sprite', 1);