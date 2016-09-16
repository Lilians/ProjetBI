#Create database projetbi;

CREATE TABLE contrat (
    contrat_name VARCHAR(100) NOT NULL PRIMARY KEY,
    commercial_name VARCHAR(100) NOT NULL,
    country_code VARCHAR(10)
);
CREATE TABLE city (
    city_name VARCHAR(50) NOT NULL PRIMARY KEY,
    contrat_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (contrat_name)
        REFERENCES contrat (contrat_name)
);
CREATE TABLE arrondissement (
    arrondissement_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(50),
    arrondissement_name VARCHAR(50),
    FOREIGN KEY (city_name)
        REFERENCES city (city_name),
    UNIQUE (city_name, arrondissement_name)
);
CREATE TABLE station (
    station_number INT NOT NULL PRIMARY KEY,
    contrat_name VARCHAR(100) NOT NULL,
    city_name VARCHAR(50),
    arrondissement_id INT,
    station_name VARCHAR(100),
    address VARCHAR(200),
    banking BOOLEAN,
    bonus BOOLEAN,
    bike_stands INT,
    latitude FLOAT(8,6),
    longitude FLOAT(8,6),
    FOREIGN KEY (contrat_name)
        REFERENCES contrat (contrat_name),
    FOREIGN KEY (city_name)
        REFERENCES city (city_name),
    FOREIGN KEY (arrondissement_id)
        REFERENCES arrondissement (arrondissement_id)
);
CREATE TABLE station_snapshot (
    station_snapshot_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    station_number INT NOT NULL,
    available_bike_stands INT NOT NULL,
    available_bikes INT NOT NULL,
    last_update DATETIME NOT NULL,
    FOREIGN KEY (station_number)
        REFERENCES station (station_number)
)