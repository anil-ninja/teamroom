<VirtualHost *:8001>
    DocumentRoot "/var/www/dpower4/teamroom/to delete/chat_box/chat/css/collap V3/backend/src"
    ServerAdmin webmaster@afsar.com
    ServerName api.loc.collap.com
    ServerAlias www.api.loc.collap.com
    <IfModule mod_php5.c>
        php_value include_path ".:/usr/share/php:/usr/share/pear/php:/usr/share/pear:/usr/share/php/collap-upload:/usr/share/php/collap-conf"
    </IfModule>
    <Directory "/var/www/dpower4/teamroom/to delete/chat_box/chat/css/collap V3/backend/src/">
        Options -Indexes
        Options FollowSymLinks
        AllowOverride All
    </Directory>
    
#LogFormat "[%P] %h %l %u %t %D \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
LogFormat "[%P] %{forensic-id}<n %h %l %u %t %D \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
LogLevel warn
ErrorLog "/var/log/capillary/apache/errors/api_collap_error.log"
CustomLog "/var/log/capillary/apache/access/api_collap_access.log" combined env=!dontlog
ServerSignature On
</VirtualHost>
