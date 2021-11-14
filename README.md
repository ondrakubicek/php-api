# php-api

custom php rest api using php8, DI, Slim and JWT authorization

### start project
```
docker-compose up --build
```

### setup database
```MYSQL
mysql -u root -p
CREATE DATABASE php_api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `Posts` (
`id` int NOT NULL AUTO_INCREMENT,
`title` text NOT NULL,
`text` text NOT NULL,
`userId` int NOT NULL,
`timestamp` int NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `User` (
`id` int NOT NULL AUTO_INCREMENT,
`name` varchar(150) NOT NULL,
`email` varchar(255) DEFAULT NULL,
`password` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

quit
```
