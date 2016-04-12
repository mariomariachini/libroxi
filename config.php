<?php
#hello
## Have a look in includes/defaults.inc.php for examples of settings you can set here. DO NOT 
##I like this fun
#EDIT defaults.inc.php!

### Database config
$config['db_host'] = "mysql";
$config['db_user'] = "librenms";
$config['db_pass'] = "pwd4librenms";
$config['db_name'] = "librenms";
$config['db']['extension'] = 'mysqli';// mysql or mysqli

### Memcached config - We use this to store realtime usage
$config['memcached']['enable']  = FALSE;
$config['memcached']['host']    = 'localhost';
$config['memcached']['port']    = 11211;

// This is the user LibreNMS will run as
//Please ensure this user is created and has the correct permissions to your install
$config['user'] = 'librenms';

### Locations - it is recommended to keep the default
#$config['install_dir']  = "/opt/librenms";

### This should *only* be set if you want to *force* a particular hostname/port
### It will prevent the web interface being usable form any other hostname
#$config['base_url']        = "http://librenms.company.com";

### Enable this to use rrdcached. Be sure rrd_dir is within the rrdcached dir
### and that your web server has permission to talk to rrdcached.
$config['rrdcached']    = "unix:/tmp/rrdcached.sock";

### Default community
$config['snmp']['community'] = array("palvelinkeskus");

### Authentication Model
$config['auth_mechanism'] = "mysql"; # default, other options: ldap, http-auth
#$config['http_auth_guest'] = "guest"; # remember to configure this user if you use http-auth

### List of RFC1918 networks to allow scanning-based discovery
#$config['nets'][] = "10.0.0.0/8";
#$config['nets'][] = "172.16.0.0/12";
#$config['nets'][] = "192.168.0.0/16";

# following is necessary for poller-wrapper
# poller-wrapper is released public domain
$config['poller-wrapper']['alerter'] = FALSE;
# Uncomment the next line to disable daily updates
#$config['update'] = 0;

# Uncomment to submit callback stats via proxy
#$config['callback_proxy'] = "hostname:port";

# Set default port association mode for new devices (default: ifIndex)
#$config['default_port_association_mode'] = 'ifIndex';
$config['rrd_dir']       = "/data/rrd";
$config['log_file']      = "/data/logs/librenms.log";
$config['log_dir']       = "/data/logs";

#Other propper settings
$config['autodiscovery']['xdp']            = TRUE;
$config['autodiscovery']['ospf']           = TRUE;
$config['autodiscovery']['bgp']            = TRUE;
$config['autodiscovery']['snmpscan']       = FALSE;
$config['discover_services']               = FALSE;

$config['autodiscovery']['nets-exclude'][] = "0.0.0.0/0";

$config['site_style'] = "mono";
$config['front_page']       = "pages/front/default.php";

$config['poller_modules']['ipmi']                         = 0;
$config['poller_modules']['toner']                        = 0;
$config['poller_modules']['ucd-diskio']                   = 0;
$config['poller_modules']['cisco-ace-loadbalancer']       = 0;
$config['poller_modules']['cisco-ace-serverfarms']        = 0;
$config['poller_modules']['netscaler-vsvr']               = 0;
$config['poller_modules']['aruba-controller']             = 0;
$config['poller_modules']['cisco-asa-firewall']           = 0;

#Authentication
$config['auth_mechanism'] = "active_directory";
$config['auth_ad_url']                      = "ldaps://your-domain.controll.er";
$config['auth_ad_check_certificates']       = 1; // or 0
$config['auth_ad_domain']                   = "your-domain.com";
$config['auth_ad_base_dn']                  = "dc=your-domain,dc=com";
$config['auth_ad_groups']['<ad-admingroup>']['level'] = 10;
$config['auth_ad_groups']['<ad-usergroup>']['level']   = 7;
$config['auth_ad_require_groupmembership']  = 0;
$config['active_directory']['users_purge']  = 14;//Purge users who haven't logged in for 14 days.
?>

