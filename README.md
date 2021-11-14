# php-api


#setup database
``
mysql -u root -p
CREATE DATABASE php_api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'php_api_user'@'localhost' identified by 'php_api_password';
GRANT ALL on blog.* to 'rest_api_user'@'localhost';
quit
``
