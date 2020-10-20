CREATE TABLE authors (
    id int not null primary key auto_increment,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    created datetime not null,
    last_updated datetime not null
);
CREATE TABLE users (
    id int not null primary key auto_increment,
    username varchar(255) not null,
    created datetime not null,
    last_updated datetime not null
);
CREATE TABLE books (
    id int not null primary key auto_increment,
    title varchar(255) not null,
    author_id int,
    foreign key (author_id) references authors(id),
    publishing_year varchar(255),
    genre varchar(255) not null,
    created datetime not null,
    last_updated datetime not null
);
CREATE TABLE favourites (
    id int not null primary key auto_increment,
    user_id int,
    foreign key (user_id) references users(id),
    book_id int,
    foreign key (book_id) references books(id),
    created datetime not null,
    last_updated datetime not null
);