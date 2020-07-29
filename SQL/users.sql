DROP TABLE IF EXISTS users;

CREATE TABLE users (
userID SERIAL PRIMARY KEY,
email varchar(70) NOT NULL,
phone varchar(10) DEFAULT 0,
phoneProvider varchar(30),
password varchar(255) NOT NULL,
hash varchar(255) NOT NULL,
verified varchar(3) DEFAULT 'NO',
created_at TIMESTAMPTZ DEFAULT NOW(),
status char DEFUALT 'n',
contactMethod char DEFAULT 'e'
);
ALTER TABLE users OWNER TO bayerk;


INSERT INTO users(email, phone, password, pin) VALUES ('k@k.com', '9991112121', 'password', '1121');

