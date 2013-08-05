--========== OPTION TABLE ==============================--
DROP TABLE IF EXISTS tbl_option;
CREATE TABLE tbl_option(
	'name' VARCHAR NOT NULL,
	'value' VARCHAR,
	'type' VARCHAR,
	'category' VARCHAR,
	'create_time' INTEGER,
	'update_time' INTEGER,
	PRIMARY KEY('name', 'type')
);

--========== USER TABLE ================================--
DROP TABLE IF EXISTS tbl_user;
CREATE TABLE tbl_user(
	'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name' VARCHAR,
	'role' VARCHAR,
	'password' VARCHAR,
	'create_time' INTEGER,
	'update_time' INTEGER
);

--========== MEDIA TABLE ===============================--
DROP TABLE IF EXISTS tbl_media;
CREATE TABLE tbl_media(
	'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'src' VARCHAR,
	'type' VARCHAR(128),
	'create_time' INTEGER,
	'update_time' INTEGER
);

--========== MEDIA TRANSLATION TABLE ===================--
DROP TABLE IF EXISTS tbl_media_translation;
CREATE TABLE tbl_media_translation(
	'media_id' INTEGER,
	'lang' VARCHAR,
	'title' VARCHAR,
	'description' VARCHAR,
	'alt' VARCHAR,
	FOREIGN KEY('media_id')
		REFERENCES tbl_media('id')
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	PRIMARY KEY('media_id', 'lang')
);

--========== GALLERY TABLE =============================--
DROP TABLE IF EXISTS tbl_gallery;
CREATE TABLE tbl_gallery(
	'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'create_time' INTEGER,
	'update_time' INTEGER
);

--========== GALLERY TRANSLATION TABLE =============================--
DROP TABLE IF EXISTS tbl_gallery_translation;
CREATE TABLE tbl_gallery_translation(
	'gallery_id' INTEGER NOT NULL,
	'lang' VARCHAR,
  	'title' VARCHAR(256),
	'description' TEXT,
	FOREIGN KEY('gallery_id')
		REFERENCES tbl_gallery('id')
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	PRIMARY KEY('gallery_id', 'lang')
);

--========== ARTICLE TABLE =============================--
DROP TABLE IF EXISTS tbl_article;
CREATE TABLE tbl_article(
	'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'url' VARCHAR(256),
	'create_time' INTEGER,
	'update_time' INTEGER
);

--======== ARTICLE TRANSLATION TABLE ===================--
DROP TABLE IF EXISTS tbl_article_translation;
CREATE TABLE tbl_article_translation(
	'article_id' INTEGER NOT NULL,
	'lang' VARCHAR,
	'title' VARCHAR(256) DEFAULT NULL,
	'content' TEXT,
	FOREIGN KEY('article_id')
		REFERENCES tbl_article('id')
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	PRIMARY KEY('article_id', 'lang')
);
DROP INDEX IF EXISTS idx_article_title;
CREATE UNIQUE INDEX idx_article_title 
	ON tbl_article_translation(title);

--======= GALLERY <-> MEDIA ASSOCIATION TABLE ==========--
DROP TABLE IF EXISTS tbl_gallery_media_assoc;
CREATE TABLE tbl_gallery_media_assoc(
	'media_id' INTEGER NOT NULL,
	'gallery_id' INTEGER NOT NULL,
	'create_time' INTEGER,
	'update_time' INTEGER,
	FOREIGN KEY('media_id')
		REFERENCES tbl_media('id')
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY('gallery_id')
		REFERENCES tbl_gallery('id')
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	PRIMARY KEY('media_id', 'gallery_id')
);

INSERT INTO tbl_user('name', 'role') VALUES 
					('user1', 'reader'),
					('user2', 'admin');

INSERT INTO tbl_option('name', 'type', 'category') VALUES
					('address', 'user', 'info'),
					('email', 'user', 'info'),
					('skype', 'user', 'info'),
					('phone', 'user', 'info'),
					('facebook', 'user', 'social'),
					('twitter', 'user', 'social'),
					('tumblr', 'user', 'social'),
					('flickr', 'user', 'social'),
					('instagram', 'user', 'social'),
					('default_language', 'system', NULL);

