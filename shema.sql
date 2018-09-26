CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  category_name CHAR(255)
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_craete DATETIME,
  title CHAR(255),
  description TEXT,
  image CHAR(255),
  price INT,
  date_closed DATETIME,
  step INT,
  bets_count INT,
  price_now INT,

  user_id INT,
  user_win INT,
  category_id INT
);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_craete DATETIME,
  price INT,

  user_id INT,
  lot_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_registr DATETIME,
  user_email CHAR(255),
  user_name CHAR(255),
  user_password CHAR(255),
  user_avatar CHAR(255),
  user_contact CHAR(255),

  user_lot INT,
  user_bet INT
);

CREATE UNIQUE INDEX emails ON users(user_email);
CREATE INDEX names ON users(user_name);
CREATE UNIQUE INDEX contacts ON users(user_contact);
CREATE UNIQUE INDEX categories ON categories(category_name);
CREATE INDEX lot_titles ON lots(title);
