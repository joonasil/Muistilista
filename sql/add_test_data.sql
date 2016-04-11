-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Account (username, password, is_admin) VALUES ('Joonas', '1234', true);
INSERT INTO Account (username, password, is_admin) VALUES ('Kalle', 'Kalle123', false);

INSERT INTO Errand (user_id, description, priority, deadline) VALUES (1, 'Pushaa tämän viikon asiat githubiin', 9001, "2016-04-04");

INSERT INTO Category (category_name) VALUES ('opiskelu');