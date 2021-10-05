CREATE USER 'myadmin'@'localhost' IDENTIFIED BY 'myadminpass';
GRANT ALL PRIVILEGES ON .*. TO 'myadmin'@'localhost';
FLUSH PRIVILEGES;