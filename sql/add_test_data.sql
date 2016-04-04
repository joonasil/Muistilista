-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Account (username, password) VALUES ('Joonas', '1234');
INSERT INTO Account (username, password) VALUES ('Kalle', 'Kalle123');

INSERT INTO Errand (description, priority, deadline) VALUES ('Pushaa tämän viikon asiat githubiin', 9001, NOW());

INSERT INTO Category (category_name) VALUES ('opiskelu');