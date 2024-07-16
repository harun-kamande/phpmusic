CREATE DATABASE if not exists music_hitts;
use music_hitts;
create table if not exists users (id integer primary key auto_increment,
user_name varchar(100),
email varchar(200));

alter table users
add column password varchar(100);

create table music(id integer primary key auto_increment,
music_title varchar(100),
artist varchar(100),
music_filepath varchar(200),
user_id integer,
foreign key(user_id)
references users(id));

alter table music
drop column artist;


