apt-get update
apt-get -y install apache2
apt-get -y install nginx
apt-get -y install sysstat
apt-get install libapache2-mod-php7.0
a2enmod php7.0
cp index.php /var/www/html/index.php
chmod 755 /var/www/html/index.php
cp apache2-sysinfo.conf /etc/apache2/sites-available/apache2-sysinfo.conf
rm /etc/nginx/sites-enabled/default
cp nginx-sysinfo.conf  /etc/nginx/sites-enabled/default
cat ports.conf > /etc/apache2/ports.conf 
a2ensite apache2-sysinfo
service apache2 reload
service apache2 restart
touch /var/log/mpstat.log  /var/log/iostat.log  /var/log/tcp.log /var/log/udp.log /var/log/df.log /var/log/network.log
crontab cron.bak
service nginx restart
