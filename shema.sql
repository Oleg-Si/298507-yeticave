CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  category_name CHAR
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_craete DATETIME,
  title CHAR,
  description TEXT,
  image CHAR,
  price INT,
  date_closed DATETIME,
  step INT,

  user_id INT,
  user_win INT,
  category_id INT
);

CREATE TABLE bet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_craete DATETIME,
  price INT,

  user_id INT,
  lot_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_registr DATETIME,
  user_email CHAR,
  user_name INT,
  user_password CHAR,
  user_avatar CHAR,
  user_contact CHAR,

  user_lot INT,
  user_bet INT
);

CREATE UNIQUE INDEX emails ON users(user_email);
CREATE UNIQUE INDEX names ON users(user_name);
CREATE UNIQUE INDEX passwords ON users(user_password);
CREATE UNIQUE INDEX contacts ON users(user_contact);
CREATE UNIQUE INDEX categories ON categories(category_name);
CREATE UNIQUE INDEX lot_titles ON lots(title);
