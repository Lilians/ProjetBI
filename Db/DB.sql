# noinspection SqlNoDataSourceInspectionForFile
Create database projetbi;

CREATE TABLE contrat (
    contrat_name VARCHAR(100) NOT NULL PRIMARY KEY,
    commercial_name VARCHAR(100) NOT NULL,
    country_code VARCHAR(10)
);
CREATE TABLE cities (
    city_id INT NOT NULL PRIMARY KEY,
    city_name VARCHAR(50),
    contrat_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (contrat_name)
        REFERENCES contrat (contrat_name)
);
CREATE TABLE station (
    station_number INT NOT NULL PRIMARY KEY,
    contrat_name VARCHAR(100) NOT NULL,
    station_name VARCHAR(100),
    address VARCHAR(200),
    banking BOOLEAN,
    bonus BOOLEAN,
    bike_stands INT,
    FOREIGN KEY (contrat_name)
        REFERENCES contrat (contrat_name)
);
CREATE TABLE station_snapshot (
    station_snapshot_id INT NOT NULL PRIMARY KEY,
    station_number INT NOT NULL,
    available_bike_stands INT NOT NULL,
    available_bikes INT NOT NULL,
    last_update DATETIME NOT NULL,
    FOREIGN KEY (station_number)
        REFERENCES station (station_number)
)