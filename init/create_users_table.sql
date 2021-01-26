CREATE TABLE users (
          did bigserial NOT NULL PRIMARY KEY,
          name varchar(50) NOT NULL CHECK (name <> ''),
          family varchar(50) NOT NULL CHECK (family <> ''),
          patronymic varchar(50) NOT NULL CHECK (family <> '')
);