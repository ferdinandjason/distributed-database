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
        mysql -u admin -padmin -h 127.0.0.1 -P 6032 < /vagrant/sql/proxysql.sql
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
