CREATE DATABASE capstone_pi_readings;
CREATE user 'capstone_pi_readings'@'%' IDENTIFIED BY 'capstone_pi_readings';
GRANT ALL PRIVILEGES ON capstone_pi_readings.* TO 'capstone_pi_readings'@'%';
FLUSH PRIVILEGES;
