drop table if exists article;
drop table if exists calendar;
drop table if exists student;
drop table if exists articleTag;
drop table if exists tag;
drop table if exists artical;
drop table if exists author;





create table author(
	authorId binary(16) not null,
	authorAvatarUrl varchar(255),
	authorActivationToken char(32),
	authorEmail varchar(128) not null,
	authorHash char(97) not null,
	authorUsername varchar(32) not null,
	unique(authorEmail),
	unique(authorUsername),
	INDEX(authorEmail),
	primary key(authorId)
);