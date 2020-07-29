DROP TABLE IF EXISTS phoneCarriers;

CREATE TABLE phoneCarriers (
providerID SERIAL PRIMARY KEY,
providerName varchar(40) NOT NULL,
providerCode varchar(40) NOT NULL
);


ALTER TABLE phoneCarriers OWNER TO bayerk;

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Bell and Solo', 'txt.bell.ca');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Rogers', 'pcs.rogers.com');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Fido', 'sms.fido.ca');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Telus', 'msg.telus.com');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Virgin Mobile', 'vmobile.ca');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('PC Mobile', 'mobiletxt.ca');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Koodo', 'msg.koodomobile.com');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Sasktel', 'sms.sasktel.com');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('MTS Allstream Inc', 'text.mts.net');

INSERT INTO phoneCarriers (providerName, providerCode) VALUES ('Wind Mobile', 'txt.windmobile.ca');

