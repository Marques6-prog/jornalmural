-- jornalmural.category definition

-- Drop table

-- DROP TABLE jornalmural.category;

CREATE DATABASE IF NOT EXISTS jornalmural
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

USE jornalmural;

CREATE TABLE jornalmural.category (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp() NOT NULL,
	updated_at TIMESTAMP DEFAULT current_timestamp() NOT NULL,
	CONSTRAINT `PRIMARY` PRIMARY KEY (id)
);

-- jornalmural.post definition

-- Drop table

-- DROP TABLE jornalmural.post;

CREATE TABLE jornalmural.post (
	id INT NOT NULL AUTO_INCREMENT,
	category_id INT,
	title VARCHAR(100) NOT NULL,
	description TEXT(65535) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp() NOT NULL,
	updated_at TIMESTAMP DEFAULT current_timestamp() NOT NULL,
	image TEXT(65535),
	state SMALLINT NOT NULL DEFAULT 1,
	CONSTRAINT `PRIMARY` PRIMARY KEY (id)
);
CREATE INDEX category_id ON jornalmural.post (category_id);


-- jornalmural.post foreign keys

ALTER TABLE jornalmural.post ADD CONSTRAINT post_ibfk_1 FOREIGN KEY (category_id) REFERENCES jornalmural.category(id) ON DELETE RESTRICT ON UPDATE RESTRICT;


-- jornalmural.user definition

-- Drop table

-- DROP TABLE jornalmural.`user`;

CREATE TABLE jornalmural.`user` (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(80) NOT NULL,
	email VARCHAR(80) NOT NULL,
	password TEXT(65535) NOT NULL,
	image TEXT(65535) NOT NULL,
	isadmin SMALLINT,
	CONSTRAINT `PRIMARY` PRIMARY KEY (id)
);

-- jornalmural.comments definition

-- Drop table

-- DROP TABLE jornalmural.comments;

CREATE TABLE jornalmural.comments (
	id INT NOT NULL AUTO_INCREMENT,
	post_id INT,
	user_id INT,
	username VARCHAR(80) NOT NULL,
	description TEXT(65535) NOT NULL,
	created_at TIMESTAMP DEFAULT current_timestamp() NOT NULL,
	updated_at TIMESTAMP DEFAULT current_timestamp() NOT NULL,
	CONSTRAINT `PRIMARY` PRIMARY KEY (id)
);
CREATE INDEX post_id ON jornalmural.comments (post_id);
CREATE INDEX user_id ON jornalmural.comments (user_id);


-- jornalmural.comments foreign keys

ALTER TABLE jornalmural.comments ADD CONSTRAINT comments_ibfk_1 FOREIGN KEY (post_id) REFERENCES jornalmural.post(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE jornalmural.comments ADD CONSTRAINT comments_ibfk_2 FOREIGN KEY (user_id) REFERENCES jornalmural.`user`(id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- jornalmural.views definition

-- Drop table

-- DROP TABLE jornalmural.views;

CREATE TABLE jornalmural.views (
	id INT NOT NULL AUTO_INCREMENT,
	post_id INT,
	user_id INT,
	CONSTRAINT `PRIMARY` PRIMARY KEY (id)
);
CREATE INDEX post_id ON jornalmural.views (post_id);
CREATE INDEX user_id ON jornalmural.views (user_id);


-- jornalmural.views foreign keys

ALTER TABLE jornalmural.views ADD CONSTRAINT views_ibfk_1 FOREIGN KEY (post_id) REFERENCES jornalmural.post(id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE jornalmural.views ADD CONSTRAINT views_ibfk_2 FOREIGN KEY (user_id) REFERENCES jornalmural.`user`(id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Unique website visitor tracking
CREATE TABLE IF NOT EXISTS jornalmural.site_visit (
  id INT NOT NULL AUTO_INCREMENT,
  visitor_key VARCHAR(64) NOT NULL,
  visited_at TIMESTAMP DEFAULT current_timestamp(),
  CONSTRAINT `PRIMARY_VISIT` PRIMARY KEY (id),
  CONSTRAINT `UNIQUE_VISITOR` UNIQUE (visitor_key)
);