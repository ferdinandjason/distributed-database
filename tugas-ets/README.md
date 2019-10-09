### Tugas ETS Basis Data Terdistribusi
# Implementasi Infrastruktur Multi-Master Basis Data
Ferdinand Jason Gondowijoyo (05111640000033)

## Table of Contents
- [Implementasi Infrastruktur Multi-Master Basis Data](#implementasi-infrastruktur-multi-master-basis-data)
  - [Table of Contents](#table-of-contents)
  - [Deskripsi Tugas](#deskripsi-tugas)
  - [Desain dan Implementasi Infrastruktur](#desain-dan-implementasi-infrastruktur)
    - [Desain Infrastruktur Basis Data Terdistribusi](#desain-infrastruktur-basis-data-terdistribusi)
    - [Implementasi Infrastruktur Basis Data Terdistribusi](#implementasi-infrastruktur-basis-data-terdistribusi)


## Deskripsi Tugas
1. Desain dan implementasi infrastruktur
    - Desain infrastruktur basis data terdistribusi + load balancing
    - Implementasi infrastruktur basis data terdistribusi
2. Penggunaan basis data terdistribusi dalam aplikasi
   - Instalasi aplikasi tambahan (misal: Apache web server, PHP, dsb)
   - Konfigurasi aplikasi tambahan tersebut
   - Deskripsi aplikasi yang dipakai (bisa berupa project yang pernah dibuat sebelumnya, web CMS yang tinggal pakai (Wordpress, Joomla, Moodle, dsb), aplikasi desktop dengan backend database, dll).
   - Konfigurasi aplikasi untuk menggunakan basis data terdistribusi yang telah dibuat.
3. Simulasi fail-over
   - Lakukan fail-over dengan cara mematikan salah satu server basi data.
   - Tunjukkan bahwa aplikasi tetap dapat berjalan dengan baik
   - Jalankan kembali server yang sebelumnya mati
   - Tunjukkan bahwa server yang sebelumnya

## Desain dan Implementasi Infrastruktur

### Desain Infrastruktur Basis Data Terdistribusi
1. Gambar Infrastruktur\
![Gambar Desain Infrastruktur](desain/Desain&#32;Infrastruktur&#32;BDT.png)\
1. Server\
Terdapat 4 Server yang digunakan pada Tugas ETS dengan pembagian IP dan Spesifikasinya sebagai berikut :
    - Server Database
        1. MySQL Server 1
            - OS : `ubuntu-16.04`
            - RAM : `512` MB
            - IP : `192.168.16.34`
        2. MySQL Server 2
            - OS : `ubuntu-16.04`
            - RAM : `512` MB
            - IP : `192.168.16.35`
        3. MySQL Server 3
            - OS : `ubuntu-16.04`
            - RAM : `512` MB
            - IP : `192.168.16.36`
    - Load Balancer
        1. Proxy SQL
            - OS : `ubuntu-16.04`
            - RAM : `512` MB
            - IP : `192.168.16.33`

### Implementasi Infrastruktur Basis Data Terdistribusi

1. Persiapan
   - Lingkungan Host : Windows 10 Education
   - Aplikasi yang harus diinstall : 
     - Vagrant (versi 2.2.5)
     - Virtual Box
2. Implementasi
   - Membuat `Vagrantfile` \
     Vagrantfile dapat dibuat dengan mengetikkan
     ```bash
     vagrant init
     ```
     Setelah melakukan perintah tersebut, maka `Vagrantfile` terbuat pada direktori tempat perintah tersebut dijalankan.     
   - Memodifikasi `Vagrantfile` tersebut menjadi sebagai berikut
     ```ruby
        # -*- mode: ruby -*-
        # vi: set ft=ruby :

        # All Vagrant configuration is done below. The "2" in Vagrant.configure
        # configures the configuration version (we support older styles for
        # backwards compatibility). Please don't change it unless you know what
        # you're doing.
        Vagrant.configure("2") do |config|
        # The most common configuration options are documented and commented below.
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        (1..3).each do |i|
            config.vm.define "db#{i}" do |node|
            node.vm.hostname = "db#{i}"
                
            # Every Vagrant development environment requires a box. You can search for
            # boxes at https://vagrantcloud.com/search.
            node.vm.box = "bento/ubuntu-16.04"

            # Create a private network, which allows host-only access to the machine
            # using a specific IP.
            node.vm.network "private_network", ip: "192.168.16.#{i+33}"

            # Create a public network, which generally matched to bridged network.
            # Bridged networks make the machine appear as another physical device on
            # your network.
            # config.vm.network "public_network", bridge: "Qualcomm Atheros QCA9377 Wireless Network Adapter"
            
            # Provider-specific configuration so you can fine-tune various
            # backing providers for Vagrant. These expose provider-specific options.
            # Example for VirtualBox:
            #
            node.vm.provider "virtualbox" do |vb|
                vb.name = "db#{i}"
                vb.gui = false
                vb.memory = "512"
            end
            #
            # View the documentation for the provider you are using for more
            # information on available options.

            # Enable provisioning with a shell script. Additional provisioners such as
            # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
            # documentation for more information about their specific syntax and use.
            node.vm.provision "shell", path: "bash/deployMySQL#{i}.sh", privileged: false
            end
        end

        config.vm.define "proxy" do |proxy|
            proxy.vm.hostname = "proxy"
            
            # Every Vagrant development environment requires a box. You can search for
            # boxes at https://vagrantcloud.com/search.
            proxy.vm.box = "bento/ubuntu-16.04"

            # Create a private network, which allows host-only access to the machine
            # using a specific IP.
            proxy.vm.network "private_network", ip: "192.168.16.33"

            # Create a public network, which generally matched to bridged network.
            # Bridged networks make the machine appear as another physical device on
            # your network.
            # config.vm.network "public_network", bridge: "Qualcomm Atheros QCA9377 Wireless Network Adapter"
            
            # Provider-specific configuration so you can fine-tune various
            # backing providers for Vagrant. These expose provider-specific options.
            # Example for VirtualBox:
            #
            proxy.vm.provider "virtualbox" do |vb|
                vb.name = "proxy"
                vb.gui = false
                vb.memory = "512"
            end
            #
            # View the documentation for the provider you are using for more
            # information on available options.

            # Enable provisioning with a shell script. Additional provisioners such as
            # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
            # documentation for more information about their specific syntax and use.
            proxy.vm.provision "shell", path: "bash/deployProxySQL.sh", privileged: false    
        end
     end
     ```
     Penjelasan : \
     `Vagrantfile` tersebut akan membuat 3 server database + 1 server load balancer dengan memory `512 MB` (sesuai dengan Gambar Infrastruktur sebelumnya)

   - Membuat Script Provision
     - Membuat Script Provision untuk `db1` (`bash/deployMySQL1.sh`)
       ```bash
        # Based on https://www.alibabacloud.com/blog/how-to-setup-mysql-group-replication-on-ubuntu-16-04_594459 with adaption

        # Changing the API source.list to kambing.uc.ac.id
        sudo cp '/vagrant/config/source.list' '/etc/apt/sources.list'

        # Updating the repo with the new sources and install some dependency required by MySQL Server
        sudo apt-get update -y
        sudo apt-get install libaio1
        sudo apt-get install libmecab2

        # Get MySQL binaries
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-server_5.7.20-1ubuntu16.04_amd64.deb

        # Setting input for installation
        sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/root-pass password admin'
        sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/re-root-pass password admin'

        # Install MySQL Community Server
        sudo dpkg -i mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-server_5.7.20-1ubuntu16.04_amd64.deb

        # Allow port on firewall
        sudo ufw allow 33061
        sudo ufw allow 3306

        # Copy MySQL configurations
        sudo cp /vagrant/config/my1.cnf /etc/mysql/my.cnf

        # Restart MySQL services
        sudo service mysql restart

        # Cluster bootstrapping
        sudo mysql -u root -padmin < /vagrant/sql/cluster_bootstrap.sql
        sudo mysql -u root -padmin < /vagrant/sql/addition_to_sys.sql
        sudo mysql -u root -padmin < /vagrant/sql/create_proxysql_user.sql
       ```
       Penjelasan :
       1. Akan menginstall dependency yang diperlukan MySQL Server.
       2. Mengganti source list ke `kambing.ui.ac.id`
       3. Mendownload binary dari MySQL (`common`, `community-client`, `client`,`community-server`) dari versi `5.7.20`
       4. Meninstall MySQL Community Server
       5. Mengizinkan penggunaan port `33061` dan `3306`
       6. Menganti config mysql (`/etc/mysql/my.cnf`) dengan konfigurasi custom (`/vagrant/config/my1.cnf`)
       7. Restart MySQL Community Server
       8. Membuat user MySQL, menginstall plugin serta beberapa script untuk keperluan replikasi.
    
     - Membuat Script Provision untuk `db2` (`bash/deployMySQL2.sh`)
       ```bash
        # Based on https://www.alibabacloud.com/blog/how-to-setup-mysql-group-replication-on-ubuntu-16-04_594459 with adaption

        # Changing the API source.list to kambing.uc.ac.id
        sudo cp '/vagrant/config/source.list' '/etc/apt/sources.list'

        # Updating the repo with the new sources and install some dependency required by MySQL Server
        sudo apt-get update -y
        sudo apt-get install libaio1
        sudo apt-get install libmecab2

        # Get MySQL binaries
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-server_5.7.20-1ubuntu16.04_amd64.deb

        # Setting input for installation
        sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/root-pass password admin'
        sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/re-root-pass password admin'

        # Install MySQL Community Server
        sudo dpkg -i mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-server_5.7.20-1ubuntu16.04_amd64.deb

        # Allow port on firewall
        sudo ufw allow 33061
        sudo ufw allow 3306

        # Copy MySQL configurations
        sudo cp /vagrant/config/my2.cnf /etc/mysql/my.cnf

        # Restart MySQL services
        sudo service mysql restart

        # Cluster bootstrapping
        sudo mysql -u root -padmin < /vagrant/sql/cluster_member.sql
       ```
       Penjelasan : 
       1. Akan menginstall dependency yang diperlukan MySQL Server.
       2. Mengganti source list ke `kambing.ui.ac.id`
       3. Mendownload binary dari MySQL (`common`, `community-client`, `client`,`community-server`) dari versi `5.7.20`
       4. Meninstall MySQL Community Server
       5. Mengizinkan penggunaan port `33061` dan `3306`
       6. Menganti config mysql (`/etc/mysql/my.cnf`) dengan konfigurasi custom (`/vagrant/config/my1.cnf`)
       7. Restart MySQL Community Server
       8. Membuat user MySQL dan menginstall plugin

     - Membuat Script Provision untuk `db3` (`bash/deployMySQL3.sh`)
       ```bash
        # Based on https://www.alibabacloud.com/blog/how-to-setup-mysql-group-replication-on-ubuntu-16-04_594459 with adaption

        # Changing the API source.list to kambing.uc.ac.id
        sudo cp '/vagrant/config/source.list' '/etc/apt/sources.list'

        # Updating the repo with the new sources and install some dependency required by MySQL Server
        sudo apt-get update -y
        sudo apt-get install libaio1
        sudo apt-get install libmecab2

        # Get MySQL binaries
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-server_5.7.20-1ubuntu16.04_amd64.deb

        # Setting input for installation
        sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/root-pass password admin'
        sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/re-root-pass password admin'

        # Install MySQL Community Server
        sudo dpkg -i mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-server_5.7.20-1ubuntu16.04_amd64.deb

        # Allow port on firewall
        sudo ufw allow 33061
        sudo ufw allow 3306

        # Copy MySQL configurations
        sudo cp /vagrant/config/my3.cnf /etc/mysql/my.cnf

        # Restart MySQL services
        sudo service mysql restart

        # Cluster bootstrapping
        sudo mysql -u root -padmin < /vagrant/sql/cluster_member.sql
       ```
       Penjelasan:
       1. Akan menginstall dependency yang diperlukan MySQL Server.
       2. Mengganti source list ke `kambing.ui.ac.id`
       3. Mendownload binary dari MySQL (`common`, `community-client`, `client`,`community-server`) dari versi `5.7.20`
       4. Meninstall MySQL Community Server
       5. Mengizinkan penggunaan port `33061` dan `3306`
       6. Menganti config mysql (`/etc/mysql/my.cnf`) dengan konfigurasi custom (`/vagrant/config/my1.cnf`)
       7. Restart MySQL Community Server
       8. Membuat user MySQL dan menginstall plugin

     - Membuat Script Provision untuk `proxy` (`bash/deployProxySQL.sh`)
       ```bash
        # Changing the APT sources.list to kambing.ui.ac.id
        sudo cp '/vagrant/config/sources.list' '/etc/apt/sources.list'

        # Updating the repo with the new sources
        sudo apt-get update -y

        cd /tmp
        curl -OL https://github.com/sysown/proxysql/releases/download/v1.4.4/proxysql_1.4.4-ubuntu16_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        curl -OL https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-client_5.7.20-1ubuntu16.04_amd64.deb

        sudo apt-get install libaio1
        sudo apt-get install libmecab2

        sudo dpkg -i proxysql_1.4.4-ubuntu16_amd64.deb
        sudo dpkg -i mysql-common_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-community-client_5.7.20-1ubuntu16.04_amd64.deb
        sudo dpkg -i mysql-client_5.7.20-1ubuntu16.04_amd64.deb

        sudo ufw allow 33061
        sudo ufw allow 3306

        sudo systemctl start proxysql
       ```
       Penjelasan :
       1. Akan menginstall dependency yang diperlukan MySQL Server.
       2. Mengganti source list ke `kambing.ui.ac.id`
       3. Mendownload binary dari MySQL (`common`, `community-client`, `client`,`proxysql`) dari versi `5.7.20`
       4. Meninstall ProxySQL
       5. Mengizinkan penggunaan port `33061` dan `3306`
       6. Restart ProxySQL
       7. Mendaftarkan username dan host dari database group replication pada ProxySQL

   - Membuat File Konfigurasi SQL
     - Membuat File Konfigurasi pada `db1` (`my1.cnf`)
       ```ini
        #
        # The MySQL database server configuration file.
        #
        # You can copy this to one of:
        # - "/etc/mysql/my.cnf" to set global options,
        # - "~/.my.cnf" to set user-specific options.
        # 
        # One can use all long options that the program supports.
        # Run program with --help to get a list of available options and with
        # --print-defaults to see which it would actually understand and use.
        #
        # For explanations see
        # http://dev.mysql.com/doc/mysql/en/server-system-variables.html

        #
        # * IMPORTANT: Additional settings that can override those from this file!
        #   The files must end with '.cnf', otherwise they'll be ignored.
        #

        !includedir /etc/mysql/conf.d/
        !includedir /etc/mysql/mysql.conf.d/

        [mysqld]

        # General replication settings
        gtid_mode = ON
        enforce_gtid_consistency = ON
        master_info_repository = TABLE
        relay_log_info_repository = TABLE
        binlog_checksum = NONE
        log_slave_updates = ON
        log_bin = binlog
        binlog_format = ROW
        transaction_write_set_extraction = XXHASH64
        loose-group_replication_bootstrap_group = OFF
        loose-group_replication_start_on_boot = ON
        loose-group_replication_ssl_mode = REQUIRED
        loose-group_replication_recovery_use_ssl = 1

        # Shared replication group configuration
        loose-group_replication_group_name = "75187266-21a0-4c3f-9dbb-eb09b986e7af"
        loose-group_replication_ip_whitelist = "192.168.16.34, 192.168.16.35, 192.168.16.36"
        loose-group_replication_group_seeds = "192.168.16.34:33061, 192.168.16.35:33061, 192.168.16.36:33061"

        # Single or Multi-primary mode? Uncomment these two lines
        # for multi-primary mode, where any host can accept writes
        loose-group_replication_single_primary_mode = OFF
        loose-group_replication_enforce_update_everywhere_checks = ON

        # Host specific replication configuration
        server_id = 1
        bind-address = "192.168.16.34"
        report_host = "192.168.16.34"
        loose-group_replication_local_address = "192.168.16.34:33061"
       ```
       Penjelasan:
       1. Membuat variable `gtid` menjadi `ON`
       2. Memberikan `loose-group_replication_group_name` universal unique ID (UUID).
       3. Memberikan `loose-group_replication_ip_whitelist` list IP pada group replication
       4. Memberikan `loose-group_replication_group_seeds` list IP dan port pada group replication
       5. Membuat variable `loose-group_replication_single_primary_mode` menjadi `OFF`
       6. Membuat variable `loose-group_replication_enforce_update_everywhere_checks` menjadi `ON`
       7. Memberikan `server_id` = 1, `bind-address`, `report_host`, `loose-group_replication_local_address` IP dan port host tersebut.

     - Membuat File Konfigurasi pada `db2` (`my2.cnf`)
       ```ini
        #
        # The MySQL database server configuration file.
        #
        # You can copy this to one of:
        # - "/etc/mysql/my.cnf" to set global options,
        # - "~/.my.cnf" to set user-specific options.
        # 
        # One can use all long options that the program supports.
        # Run program with --help to get a list of available options and with
        # --print-defaults to see which it would actually understand and use.
        #
        # For explanations see
        # http://dev.mysql.com/doc/mysql/en/server-system-variables.html

        #
        # * IMPORTANT: Additional settings that can override those from this file!
        #   The files must end with '.cnf', otherwise they'll be ignored.
        #

        !includedir /etc/mysql/conf.d/
        !includedir /etc/mysql/mysql.conf.d/

        [mysqld]

        # General Replication settings
        gtid_mode = ON
        enforce_gtid_consistency = ON
        master_info_repository = TABLE
        relay_log_info_repository = TABLE
        binlog_checksum = NONE
        log_slave_updates = ON
        log_bin = binlog
        binlog_format = ROW
        transaction_write_set_extraction = XXHASH64
        loose-group_replication_bootstrap_group = OFF
        loose-group_replication_start_on_boot = ON
        loose-group_replication_ssl_mode = REQUIRED
        loose-group_replication_recovery_use_ssl = 1

        # Shared replication group configuration
        loose-group_replication_group_name = "75187266-21a0-4c3f-9dbb-eb09b986e7af"
        loose-group_replication_ip_whitelist = "192.168.16.34, 192.168.16.35, 192.168.16.36"
        loose-group_replication_group_seeds = "192.168.16.34:33061, 192.168.16.35:33061, 192.168.16.36:33061"

        # Single or Multi-primary mode? Uncomment these two lines
        # for multi-primary mode, where any host can accept writes
        loose-group_replication_single_primary_mode = OFF
        loose-group_replication_enforce_update_everywhere_checks = ON

        # Host specific replication configuration
        server_id = 2
        bind-address = "192.168.16.35"
        report_host = "192.168.16.35"
        loose-group_replication_local_address = "192.168.16.35:33061"
       ```
       Penjelasan:
       1. Membuat variable `gtid` menjadi `ON`
       2. Memberikan `loose-group_replication_group_name` universal unique ID (UUID).
       3. Memberikan `loose-group_replication_ip_whitelist` list IP pada group replication
       4. Memberikan `loose-group_replication_group_seeds` list IP dan port pada group replication
       5. Membuat variable `loose-group_replication_single_primary_mode` menjadi `OFF`
       6. Membuat variable `loose-group_replication_enforce_update_everywhere_checks` menjadi `ON`
       7. Memberikan `server_id` = 2, `bind-address`, `report_host`, `loose-group_replication_local_address` IP dan port host tersebut.

     - Membuat File Konfigurasi pada `db3` (`my3.cnf`)
       ```ini
        #
        # The MySQL database server configuration file.
        #
        # You can copy this to one of:
        # - "/etc/mysql/my.cnf" to set global options,
        # - "~/.my.cnf" to set user-specific options.
        # 
        # One can use all long options that the program supports.
        # Run program with --help to get a list of available options and with
        # --print-defaults to see which it would actually understand and use.
        #
        # For explanations see
        # http://dev.mysql.com/doc/mysql/en/server-system-variables.html

        #
        # * IMPORTANT: Additional settings that can override those from this file!
        #   The files must end with '.cnf', otherwise they'll be ignored.
        #

        !includedir /etc/mysql/conf.d/
        !includedir /etc/mysql/mysql.conf.d/

        [mysqld]

        # General Replication settings
        gtid_mode = ON
        enforce_gtid_consistency = ON
        master_info_repository = TABLE
        relay_log_info_repository = TABLE
        binlog_checksum = NONE
        log_slave_updates = ON
        log_bin = binlog
        binlog_format = ROW
        transaction_write_set_extraction = XXHASH64
        loose-group_replication_bootstrap_group = OFF
        loose-group_replication_start_on_boot = ON
        loose-group_replication_ssl_mode = REQUIRED
        loose-group_replication_recovery_use_ssl = 1

        # Shared replication group configuration
        loose-group_replication_group_name = "75187266-21a0-4c3f-9dbb-eb09b986e7af"
        loose-group_replication_ip_whitelist = "192.168.16.34, 192.168.16.35, 192.168.16.36"
        loose-group_replication_group_seeds = "192.168.16.34:33061, 192.168.16.35:33061, 192.168.16.36:33061"

        # Single or Multi-primary mode? Uncomment these two lines
        # for multi-primary mode, where any host can accept writes
        loose-group_replication_single_primary_mode = OFF
        loose-group_replication_enforce_update_everywhere_checks = ON

        # Host specific replication configuration
        server_id = 3
        bind-address = "192.168.16.36"
        report_host = "192.168.16.36"
        loose-group_replication_local_address = "192.168.16.36:33061"
       ```
       Penjelasan:
       1. Membuat variable `gtid` menjadi `ON`
       2. Memberikan `loose-group_replication_group_name` universal unique ID (UUID).
       3. Memberikan `loose-group_replication_ip_whitelist` list IP pada group replication
       4. Memberikan `loose-group_replication_group_seeds` list IP dan port pada group replication
       5. Membuat variable `loose-group_replication_single_primary_mode` menjadi `OFF`
       6. Membuat variable `loose-group_replication_enforce_update_everywhere_checks` menjadi `ON`
       7. Memberikan `server_id` = 3, `bind-address`, `report_host`, `loose-group_replication_local_address` IP dan port host tersebut.

   - Membuat File Script SQL Pendukung
     - File `addition_to_sys.sql`\
       Merupakan patch script untuk ProxySQL, berikut script nya
       ```sql
        USE sys;

        DELIMITER $$

        CREATE FUNCTION IFZERO(a INT, b INT)
        RETURNS INT
        DETERMINISTIC
        RETURN IF(a = 0, b, a)$$

        CREATE FUNCTION LOCATE2(needle TEXT(10000), haystack TEXT(10000), offset INT)
        RETURNS INT
        DETERMINISTIC
        RETURN IFZERO(LOCATE(needle, haystack, offset), LENGTH(haystack) + 1)$$

        CREATE FUNCTION GTID_NORMALIZE(g TEXT(10000))
        RETURNS TEXT(10000)
        DETERMINISTIC
        RETURN GTID_SUBTRACT(g, '')$$

        CREATE FUNCTION GTID_COUNT(gtid_set TEXT(10000))
        RETURNS INT
        DETERMINISTIC
        BEGIN
        DECLARE result BIGINT DEFAULT 0;
        DECLARE colon_pos INT;
        DECLARE next_dash_pos INT;
        DECLARE next_colon_pos INT;
        DECLARE next_comma_pos INT;
        SET gtid_set = GTID_NORMALIZE(gtid_set);
        SET colon_pos = LOCATE2(':', gtid_set, 1);
        WHILE colon_pos != LENGTH(gtid_set) + 1 DO
            SET next_dash_pos = LOCATE2('-', gtid_set, colon_pos + 1);
            SET next_colon_pos = LOCATE2(':', gtid_set, colon_pos + 1);
            SET next_comma_pos = LOCATE2(',', gtid_set, colon_pos + 1);
            IF next_dash_pos < next_colon_pos AND next_dash_pos < next_comma_pos THEN
            SET result = result +
                SUBSTR(gtid_set, next_dash_pos + 1,
                        LEAST(next_colon_pos, next_comma_pos) - (next_dash_pos + 1)) -
                SUBSTR(gtid_set, colon_pos + 1, next_dash_pos - (colon_pos + 1)) + 1;
            ELSE
            SET result = result + 1;
            END IF;
            SET colon_pos = next_colon_pos;
        END WHILE;
        RETURN result;
        END$$

        CREATE FUNCTION gr_applier_queue_length()
        RETURNS INT
        DETERMINISTIC
        BEGIN
        RETURN (SELECT sys.gtid_count( GTID_SUBTRACT( (SELECT
        Received_transaction_set FROM performance_schema.replication_connection_status
        WHERE Channel_name = 'group_replication_applier' ), (SELECT
        @@global.GTID_EXECUTED) )));
        END$$

        CREATE FUNCTION gr_member_in_primary_partition()
        RETURNS VARCHAR(3)
        DETERMINISTIC
        BEGIN
        RETURN (SELECT IF( MEMBER_STATE='ONLINE' AND ((SELECT COUNT(*) FROM
        performance_schema.replication_group_members WHERE MEMBER_STATE != 'ONLINE') >=
        ((SELECT COUNT(*) FROM performance_schema.replication_group_members)/2) = 0),
        'YES', 'NO' ) FROM performance_schema.replication_group_members JOIN
        performance_schema.replication_group_member_stats USING(member_id));
        END$$

        CREATE VIEW gr_member_routing_candidate_status AS SELECT
        sys.gr_member_in_primary_partition() as viable_candidate,
        IF( (SELECT (SELECT GROUP_CONCAT(variable_value) FROM
        performance_schema.global_variables WHERE variable_name IN ('read_only',
        'super_read_only')) != 'OFF,OFF'), 'YES', 'NO') as read_only,
        sys.gr_applier_queue_length() as transactions_behind, Count_Transactions_in_queue as 'transactions_to_cert' from performance_schema.replication_group_member_stats;$$

        DELIMITER ;

       ```
     - File `cluster_bootstrap.sql`\
       Merupakan script untuk melakukan bootstrapping MySQL group replication (hanya dilakukan pada salah satu db server saja, pada tugas ini digunakan pada `db1`). Berikut scriptnya
       ```sql
        SET SQL_LOG_BIN=0;
        CREATE USER 'repl'@'%' IDENTIFIED BY 'password' REQUIRE SSL;
        GRANT REPLICATION SLAVE ON *.* TO 'repl'@'%';
        FLUSH PRIVILEGES;
        SET SQL_LOG_BIN=1;

        CHANGE MASTER TO MASTER_USER='repl', MASTER_PASSWORD='password' FOR CHANNEL 'group_replication_recovery';
        INSTALL PLUGIN group_replication SONAME 'group_replication.so';

        SET GLOBAL group_replication_bootstrap_group=ON;
        START GROUP_REPLICATION;
        SET GLOBAL group_replication_bootstrap_group=OFF;

        CREATE DATABASE my_buffet;
       ```
     - File `cluster_member`\
       Merupakan script untuk melakukan konfigurasi MySQL group replication pada node db yang lain (node member). Berikut scriptnya
       ```sql
        SET SQL_LOG_BIN=0;
        CREATE USER 'repl'@'%' IDENTIFIED BY 'password' REQUIRE SSL;
        GRANT REPLICATION SLAVE ON *.* TO 'repl'@'%';
        FLUSH PRIVILEGES;
        SET SQL_LOG_BIN=1;

        CHANGE MASTER TO MASTER_USER='repl', MASTER_PASSWORD='password' FOR CHANNEL 'group_replication_recovery';
        INSTALL PLUGIN group_replication SONAME 'group_replication.so';
       ```
     - File `create_proxysql_user.sql`\
       Merupakan script untuk membuat user untuk ProxySQL (‘monitor’ untuk monitoring, mybufferuser untuk contoh aplikasi). Berikut scriptnya
       ```sql
        CREATE USER 'monitor'@'%' IDENTIFIED BY 'monitorpassword';
        GRANT SELECT on sys.* to 'monitor'@'%';
        FLUSH PRIVILEGES;

        CREATE USER 'mybuffetuser'@'%' IDENTIFIED BY 'mybuffetpassword';
        GRANT ALL PRIVILEGES on my_buffet.* to 'mybuffetuser'@'%';
        FLUSH PRIVILEGES;
       ```
     - File `proxysql.sql`
       Merupakan script untuk mengubah user admin ProxySQL, menambahkan user ‘monitoring’, menambahkan node MySQL, menambahkan user ‘mybuffetuser’. Berikut scriptnya
       ```sql
        UPDATE global_variables SET variable_value='admin:password' WHERE variable_name='admin-admin_credentials';
        LOAD ADMIN VARIABLES TO RUNTIME;
        SAVE ADMIN VARIABLES TO DISK;

        UPDATE global_variables SET variable_value='monitor' WHERE variable_name='mysql-monitor_username';
        LOAD MYSQL VARIABLES TO RUNTIME;
        SAVE MYSQL VARIABLES TO DISK;

        INSERT INTO mysql_group_replication_hostgroups (writer_hostgroup, backup_writer_hostgroup, reader_hostgroup, offline_hostgroup, active, max_writers, writer_is_also_reader, max_transactions_behind) VALUES (2, 4, 3, 1, 1, 3, 1, 100);

        INSERT INTO mysql_servers(hostgroup_id, hostname, port) VALUES (2, '192.168.16.34', 3306);
        INSERT INTO mysql_servers(hostgroup_id, hostname, port) VALUES (2, '192.168.16.35', 3306);
        INSERT INTO mysql_servers(hostgroup_id, hostname, port) VALUES (2, '192.168.16.36', 3306);

        LOAD MYSQL SERVERS TO RUNTIME;
        SAVE MYSQL SERVERS TO DISK;

        INSERT INTO mysql_users(username, password, default_hostgroup) VALUES ('mybuffetuser', 'mybuffetpassword', 2);
        LOAD MYSQL USERS TO RUNTIME;
        SAVE MYSQL USERS TO DISK;   
       ```

3. Menjalankan Vagrant
- Setelah membuat `Vagrantfile` serta segala file yang dibutuhkan. maka vagrant virtual box bisa dijalankan dengan
```bash
vagrant up
```
- Setelah menunggu download dan provisining, cek vagrant sudah berjalan dengan baik dengan
```bash
vagrant status
```
```
SS Soon
```
- Masuk ke dalam VM Proxy
```
vagrant ssh proxy
```
- Masukkan file proxysql.sql sebagai provisioning tambahan
```
mysql -u admin -p -h 127.0.0.1 -P 6032 < /vagrant/proxysql.sql
```
