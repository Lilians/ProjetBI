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
    latitude FLOAT(8,6),
    longitude FLOAT(8,6),
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
    latitude FLOAT(8,6) DEFAULT NULL,
    longitude FLOAT(8,6) DEFAULT NULL,
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
);
CREATE TABLE meteo_arrondissement_snapshot (
    meteo_arrondissement_snapshot_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    arrondissement_id INT,
    last_time DATETIME NOT NULL,
    last_update DATETIME NOT NULL,
    FOREIGN KEY (arrondissement_id)
        REFERENCES arrondissement (arrondissement_id)
);

INSERT INTO `contrat` (`contrat_name`, `commercial_name`, `country_code`) VALUES
('Lyon', 'Vélo''V', 'FR');

INSERT INTO `city` (`city_name`, `contrat_name`) VALUES
('CALUIRE-ET-CUIRE', 'Lyon'),
('LYON', 'Lyon'),
('VAULX-EN-VELIN', 'Lyon'),
('VILLEURBANNE', 'Lyon');

INSERT INTO `arrondissement` (`arrondissement_id`, `city_name`, `arrondissement_name`, `latitude`, `longitude`) VALUES
(1, 'LYON', '1 er', 45.771292, 04.828083),
(2, 'LYON', '2 ème', 45.747711, 04.824100),
(3, 'LYON', '3 ème', 45.758260, 04.855387),
(4, 'LYON', '4 ème', 45.780952, 04.824349),
(5, 'LYON', '5 ème', 45.758262, 04.799075),
(6, 'LYON', '6 ème', 45.775107, 04.850197),
(7, 'LYON', '7 ème', 45.730425, 04.839938),
(8, 'LYON', '8 ème', 45.731538, 04.869616),
(9, 'LYON', '9 ème', 45.769942, 04.803718),
(10, 'VAULX-EN-VELIN', '-', 45.782029, 04.922661),
(11, 'VILLEURBANNE', '-', 45.771944, 04.890171),
(12, 'CALUIRE-ET-CUIRE', '-', 45.796810, 04.842426);