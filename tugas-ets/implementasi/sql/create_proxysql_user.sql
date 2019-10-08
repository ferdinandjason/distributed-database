CREATE USER 'monitor'@'%' IDENTIFIED BY 'monitorpassword';
GRANT SELECT on sys.* to 'monitor'@'%';
FLUSH PRIVILEGES;

CREATE USER 'mybuffetuser'@'%' IDENTIFIED BY 'mybuffetpassword';
GRANT ALL PRIVILEGES on my_buffet.* to 'mybuffetuser'@'%';
FLUSH PRIVILEGES;