sudo cp /vagrant/sources/hosts /etc/hosts
sudo cp '/vagrant/sources/sources.list' '/etc/apt/'

sudo apt update -y

# Install Apache2
sudo apt install apache2 -y
sudo ufw allow in "Apache Full"

# Install MySQL
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password admin'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password admin'
sudo apt install mysql-server
sudo mysql_secure_installation -y
sudo ufw allow 3306

# Install PHP
sudo apt install php libapache2-mod-php php-mysql php-pear php-dev
sudo pecl install redis
sudo echo 'extension=redis.so' >> /etc/php/7.2/apache2/php.ini

# Configure MySQL for Wordpress
sudo mysql -u root -padmin < /vagrant/sql/wordpress.sql

# Install Wordpress
cd /tmp
wget -c http://wordpress.org/latest.tar.gz
tar -xzvf latest.tar.gz
sudo mkdir -p /var/www/html
sudo mv wordpress/* /var/www/html
sudo cp /vagrant/wp-config.php /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
sudo systemctl restart apache2
