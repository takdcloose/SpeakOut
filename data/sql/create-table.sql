---- drop ----
DROP TABLE IF EXISTS `userinfo`;


create table IF not exists `userinfo`
(
 `username`         VARCHAR(50) NOT NULL,
 `usermail`         VARCHAR(50) NOT NULL,
 `userpass`         VARCHAR(256) NOT NULL,
 `phone`            VARCHAR(100) NOT NULL,
 `comment`          VARCHAR(300),
    PRIMARY KEY (`usermail`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

---- drop ----
DROP TABLE IF EXISTS `bulletin`;

---- create ----
create table IF not exists `bulletin`
(
 `id`               INT(300) AUTO_INCREMENT,
 `time`             VARCHAR(50) NOT NULL,
 `theme`            VARCHAR(50),
 `video`            VARCHAR(5) NUT NULL,
 `mylang`           VARCHAR(50) NOT NULL,
 `yourlang`         VARCHAR(50) NOT NULL,
 `other`            VARCHAR(100),
    PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
