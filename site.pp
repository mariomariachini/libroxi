class { 'docker':
   version => 'latest',
   before  =>Exec['MySQLsetup'],
        }

exec{'MySQLsetup':
        command         =>'docker run -d -m 1g -v /home/mysql:/var/lib/mysql -e DB_USER=librenms -e DB_PASS=pwd4librenms -e DB_NAME=librenms --name librenms-db  sameersbn/mysql:latest',
        path            =>'/bin/',
        }

exec{'LibreNMSSetup':
        require         =>Exec['MySQLsetup'],
        command         =>'docker build -qt seti/librenms librenms-oxidized/; docker run -v /data:/data -p 80:80 -e TZ="Europe/Vienna" --link librenms-db:mysql -e POLLER=24 --name librenms  -t seti/librenms librenms',
        path            =>'/bin/',
    }
	
exec{'OxidizedSetup':
        require         =>Exec['LibreNMSSetup'],
        command         =>'git clone https://github.com/ytti/oxidized; docker build -q -t oxidized/oxidized:latest oxidized/; mkdir /etc/oxidized; docker run -v /etc/oxidized:/root/.config/oxidized -p 8888:8888/tcp -t oxidized/oxidized:latest oxidized --name oxidized --link librenms:librenms',
        path            =>'/bin/',
    }