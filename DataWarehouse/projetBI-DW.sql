
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
	address VARCHAR(150),
	banking boolean,
	bonus boolean,
	nb_emplacements INT,
	street VARCHAR(150),
	FOREIGN KEY (district_city_id)
		REFERENCES DistrictCity(district_city_id)
);

CREATE TABLE Contract (
	contract_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	commercial_name VARCHAR(50)
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
	day_week_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`day` INT,
	week INT,
	`month` INT,
	`year` INT
);

CREATE TABLE MinuteHour (
	minute_hour_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	day_week_id INT,
	`hour` INT,
	`minute` INT,
	FOREIGN KEY (day_week_id)
		REFERENCES DayWeek(day_week_id)
);

CREATE TABLE Snapshot (
	snapshot_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	station_street_id INT,
	contract_id INT,
	minute_hour_id INT,
	weather_id INT,
	available_bike_stands INT,
	available_bikes INT,
	FOREIGN KEY (station_street_id)
		REFERENCES StationStreet(station_street_id),
	FOREIGN KEY (contract_id)
		REFERENCES Contract(contract_id),
	FOREIGN KEY (minute_hour_id)
		REFERENCES MinuteHour(minute_hour_id),
	FOREIGN KEY (weather_id)
		REFERENCES Weather(weather_id)
);