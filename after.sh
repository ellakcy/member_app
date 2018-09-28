#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

code_path="/home/vagrant/code"
cd $code_path

echo "Clearing caches for dev environment"
php ./bin/console cache:clear
php ./bin/console cache:warmup

echo "Clearing caches for test environment"
php ./bin/console cache:clear --env=test
php ./bin/console cache:warmup --env=test

echo "Creating schemas for test environment"
php ./bin/console doctrine:schema:drop --env=test --force
php ./bin/console doctrine:schema:create --env=test

##### Php Configuration #####

echo "Configuring Xdebug"
ip=$(netstat -rn | grep "^0.0.0.0 " | cut -d " " -f10)
xdebug_config="/etc/php/$(php -v | head -n 1 | awk '{print $2}'|cut -c 1-3)/mods-available/xdebug.ini"

echo "Xdebug config file ${xdebug_config}"

if [ -f "${code_path}/xdebug.conf" ]; then

  echo "Specifying the ip with ${ip}"
  sed "s/\$ip/${ip}/g" xdebug.conf > xdebug.conf.tmp

  echo "Moving Into ${xdebug_config}"
  cat xdebug.conf.tmp
  sudo cp ./xdebug.conf.tmp ${xdebug_config}
else
  echo "File not found"
fi
