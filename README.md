Official Omeka docs:

forum:  https://forum.omeka.org/c/omeka-s/8
site:   https://omeka.org/s/
github: https://github.com/omeka/omeka-s/blob/develop/README.md
modules list:  https://omeka.org/s/modules/



Dev startup:

docker-compose exec omeka chown -R www-data:www-data /var/www/html


On Upgrade: check if the source's local.config.php changes any variable names or layout.
    