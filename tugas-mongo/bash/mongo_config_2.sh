sudo bash /vagrant/bash/allhosts.sh

# Restart the mongo service 
sudo systemctl restart mongod

# Create opt directory
sudo mkdir /opt/mongo

# Assign new permission
sudo mv /vagrant/sources/mongo-keyfile /opt/mongo
sudo chmod 400 /opt/mongo/mongo-keyfile

# Own new keyfile generated
sudo chown mongodb:mongodb /opt/mongo/mongo-keyfile

# Override mongod config with current config
sudo cp /vagrant/config/mongodcsvr2.conf /etc/mongod.conf

# Restart the mongo service 
sudo systemctl restart mongod
