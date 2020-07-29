DROP TABLE IF EXISTS measurements;

CREATE TABLE measurements (
email varchar(70) PRIMARY KEY NOT NULL,
leftBicep float DEFAULT 0,
rightBicep float DEFAULT 0,
chest float DEFAULT 0,
weight float DEFAULT 0,
maxPushUps int NOT NULL,
wakeUpTime time(6) NOT NULL,
started_at DATE DEFAULT NOW(),
is_started varchar(20) DEFAULT "NO"
);
ALTER TABLE measurements OWNER TO bayerk;


INSERT INTO measurements(userID, maxPushUps, wakeUpTime, bedTime) VALUES ('1', '30', '8', '8');

INSERT INTO measurements ('email', 'leftbicep', 'rightbicep', 'chest', 'weight', 'maxpushups', 'wakeuptime', 'bedTime') VALUES ('test@test.com', '10', '10', '10', '200', '22', '11', '11');