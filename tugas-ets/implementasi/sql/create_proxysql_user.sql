CREATE USER 'monitor'@'%' IDENTIFIED BY 'monitorpassword';
GRANT SELECT on sys.* to 'monitor'@'%';
FLUSH PRIVILEGES;

CREATE USER 'mybuffetuser'@'%' IDENTIFIED BY 'mybuffetpassword';
GRANT ALL PRIVILEGES on playground.* to 'mybuffetuser'@'%';
FLUSH PRIVILEGES;