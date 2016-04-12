# Dockerfile Librenms + Oxidized
FROM ubuntu:14.04
MAINTAINER MM <wisniowy@g.pl>

# Set correct environment variables.
ENV HOME=/root \
	DEBIAN_FRONTEND=noninteractive \
	LC_ALL=C.UTF-8 \
	LANG=en_US.UTF-8 \
	LANGUAGE=en_US.UTF-8

COPY cron-librenms /etc/cron.d/librenms

RUN 
	#Proper Users
	useradd librenms -d /opt/librenms -M -r && usermod -a -G librenms www-data && \
	locale-gen pl_PL.UTF-8 && locale-gen en_US.UTF-8 && locale-gen fi_FI.UTF-8 && \ 
	
	#Update sys and install proper packages
	apt-get update -q && \
    apt-get install -y \
		libapache2-mod-php5 php5-cli php5-mysql php5-gd php5-snmp php-pear php5-curl snmp graphviz 
		php5-mcrypt php5-json apache2 fping imagemagick whois mtr-tiny nmap python-mysqldb snmpd 
		php-net-ipv4 php-net-ipv6 rrdtool git at rrdcached memcached php5-ldap && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    
	# Make proper directories and clone official librenms repo and start installation
	mkdir /opt && cd /opt && \
	git clone  --depth 1 https://github.com/librenms/librenms.git librenms && \
	cd /opt/librenms && \
	mkdir rrd logs && \
	chown -R librenms:librenms /opt/librenms && \
	chmod 775 rrd  && \
	
	#Copy configs to /etc/apache2/sites-available/librenms.conf
	COPY librenms.conf /etc/apache2/sites-available/librenms.conf
    	php5enmod mcrypt && a2ensite librenms.conf && a2enmod rewrite && service apache2 restart && a2dissite 000-default\
    	rm /etc/apache2/sites-available/default-ssl.conf && \
    	chown -R www-data:www-data /var/log/apache2 && \
    	chmod 0644 /etc/cron.d/librenms

COPY apache2.conf ports.conf /etc/apache2/
COPY apache-vhost /etc/apache2/sites-available/000-default.conf

#RRDCACHED Configuration
RUN mkdir /var/run/rrdcached && \
    chown librenms:librenms /var/run/rrdcached && \
    chmod 755 /var/run/rrdcached
COPY rrdcached /etc/default
RUN  service rrdcached restart

EXPOSE 80/tcp

VOLUME ["/data"]
