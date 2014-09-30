SET character_set_client = utf8;

USE antihoax;

DROP TABLE IF EXISTS hoax;

CREATE TABLE hoax (
	id MEDIUMINT NOT NULL AUTO_INCREMENT,
	url VARCHAR(255), 
	evidence TEXT,
	PRIMARY KEY (id),
	UNIQUE KEY(url)
 ) ENGINE=MyISAM;