#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

cd /home/vagrant/code

echo "Clearing caches for dev environment"
php ./bin/console cache:clear
php ./bin/console cache:warmup

echo "Clearing caches for test environment"
php ./bin/console cache:clear --env=test
php ./bin/console cache:warmup --env=test

echo "Creating schemas for test environment"
php ./bin/console doctrine:schema:drop --env=test --force
php ./bin/console doctrine:schema:create --env=test

echo "Configuring Xdebug"
ip=$(hostname -I | awk '{print $2}')
xdebug_config="/etc/php/$(php -v | head -n 1 | awk '{print $2}'|cut -c 1-3)/mods-available/xdebug.ini"

echo "IP for the xdebug to connect back: ${ip}"
echo "Xdebug Configuration path: ${xdebug_config}"
echo "Port for the Xdebug to connect back: ${XDEBUG_PORT}"
echo "Optimize for ${IDE} ide"

if [ $IDE=='atom' ]; then
  echo "Configuring xdebug for ATOM ide"
fi
