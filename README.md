
# SQL Injection Vulnerability Demo (PHP + MySQL)

This project demonstrates how a web application can be vulnerable to **SQL Injection** when user inputs are not properly sanitized or validated. It also shows how to fix this vulnerability using **prepared statements**.

---

## 📁 Project Structure

- `index.php` – Main PHP file with both vulnerable and secure search implementations.
- `README.md` – Documentation (this file).


## 🧱 1. Database Setup

Run the following SQL to set up the `product_db` database and `products` table:

```SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `Your_DB` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `Your_DB`;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `products` (`id`, `name`, `description`, `price`) VALUES
(1,	'imac',	'24 inch M4 chip',	135000.00),
(2,	'iphone 16',	'Starlight 128gb',	88000.00),
(3,	'Apple magic mouse',	'USB-C Multi touch surface',	7500.00);
```

# Observation:

Input this string into the product name form field:

    ' OR '1'='1

Original Query:
    SELECT * FROM products WHERE name = '' OR '1'='1'

Effect:
    - The WHERE clause becomes always TRUE because '1'='1'
    - As a result, all rows in the 'products' table are returned
    - This simulates a data leak and bypasses input filtering

This is a classic example of SQL Injection.

### Prevent this by using:

 - Prepared statements (mysqli or PDO)
 - Input validation and escaping
