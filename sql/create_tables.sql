-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Account(
    id SERIAL PRIMARY KEY,
    username varchar(20) NOT NULL,
    password varchar(20) NOT NULL
);

CREATE TABLE Errand(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES Account(id),
    description varchar(200) NOT NULL,
    priority INTEGER NOT NULL
    status boolean DEFAULT FALSE,
    deadline DATE
);

CREATE TABLE Category(
    id SERIAL PRIMARY KEY,
    category_name varchar(20) NOT NULL
);

CREATE TABLE Categories(
    errand_id INTEGER REFERENCES Errand(id),
    category_id INTEGER REFERENCES Category(id)
);