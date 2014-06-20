#!/bin/bash
apt-get update;
apt-get install -y openvpn zabbix-agent gnome-schedule ssh mc;
apt-get install -y mysql-server-5.1 apache2 php5 php5-mysql phpmyadmin;
mysql -h 127.0.0.1 -u root -pfactlib221110 < initdb.sql
mysql -h 127.0.0.1 -u inventa_bd -pValenta@04 inventa_pglibreria < inventa_pglibreria.sql;
cp client.conf /etc/openvpn/;
cp *.key /etc/openvpn/;
cp *.crt /etc/openvpn/;
cp php.ini /etc/php5/apache2/;
cp -R fdvl /var/www/;
### cp cron-lp0 /etc/cron.d/;
cp cron-openvpn /etc/cron.d/;
cp impresora.php /var/www/;
chown www-data:www-data /var/www/impresora.php;
cp zabbix_agentd.conf /etc/zabbix/;
/etc/init.d/cron restart;
### chmod 777 -R /dev/lp0;
chown -R www-data:www-data /var/www/*;
adduser www-data lp;
wget -q -O /dev/null http://127.0.0.1/impresora.php;
echo Listo;
