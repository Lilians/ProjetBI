
use `projetbi_dw`;

CREATE TABLE DistrictCity (
	district_city_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	district VARCHAR(100),
	city VARCHAR(100),
	country VARCHAR(100)
);

CREATE TABLE StationStreet (
	station_street_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	district_city_id INT,
	station_name VARCHAR(100),
	banking boolean,
	bonus boolean,
	nb_emplacements INT,
	street VARCHAR(150),
	FOREIGN KEY (district_city_id)
		REFERENCES DistrictCity(district_city_id)
);

CREATE TABLE Weather (
	weather_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	precip_intensity FLOAT(3,2),
	precip_probability FLOAT(3,2),
	temperature FLOAT(3,1),
	apparent_temperture FLOAT(3,1),
	humidity FLOAT(3,2),
	wind_speed FLOAT(5,2),
	wind_bearing INT,
	cloud_cover FLOAT(3,2),
	weather_label VARCHAR(50)
);

CREATE TABLE DayWeek (
	day_week_id VARCHAR(20) PRIMARY KEY,
	day INT,
	day_label VARCHAR(15),
	week INT,
	month INT,
	year INT,
	holidays BOOLEAN DEFAULT FALSE,
	non_working_day BOOLEAN DEFAULT FALSE
);

CREATE TABLE Hour (
	hour_id VARCHAR(20) PRIMARY KEY,
	day_week_id VARCHAR(20),
	hour INT,
	half_hour INT,
	FOREIGN KEY (day_week_id)
		REFERENCES DayWeek(day_week_id)
);

CREATE TABLE Snapshot (
	snapshot_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	station_street_id INT,
	hour_id VARCHAR(20),
	weather_id INT,
	available_bike_stands INT,
	available_bikes INT,
	FOREIGN KEY (station_street_id)
		REFERENCES StationStreet(station_street_id),
	FOREIGN KEY (hour_id)
		REFERENCES Hour(hour_id),
	FOREIGN KEY (weather_id)
		REFERENCES Weather(weather_id)
);

CREATE TABLE Neighborhood (
	neighborhood_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	station_street_id_1 INT,
	station_street_id_2 INT,
	distance INT,
	FOREIGN KEY (station_street_id_1)
		REFERENCES StationStreet(station_street_id),
	FOREIGN KEY (station_street_id_2)
		REFERENCES StationStreet(station_street_id)
);
