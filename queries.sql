/* Добавляем категории */
INSERT INTO categories(category_name) VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

/* Добавляем пользователей*/
INSERT INTO users(user_email, user_name, user_password, user_lot, user_bet) VALUES
('ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', '1', '1'), ('kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', '2', '2'),
('warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', '3', '3');

/* Добавляем объявления*/
INSERT INTO lots(date_craete, title, description, image, price, date_closed, step, bets_count, price_now,  user_id, category_id) VALUES
('2018.09.19','2014 Rossignol District Snowboard', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae earum architecto repudiandae distinctio sapiente ad inventore cupiditate consequuntur est iste?', 'img/lot-1.jpg', '10999', '2018.09.25', '1000', '0', '10999', '1', '1'),
('2018.09.20','DC Ply Mens 2016/2017 Snowboard', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae earum architecto repudiandae distinctio sapiente ad inventore cupiditate consequuntur est iste?', 'img/lot-2.jpg', '159999', '2018.10.20', '1000', '0', '159999', '1', '1'),
('2018.09.21','Крепления Union Contact Pro 2015 года размер L/XL', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae earum architecto repudiandae distinctio sapiente ad inventore cupiditate consequuntur est iste?', 'img/lot-3.jpg', '8000', '2018.10.20', '1000', '0', '8000', '3', '2'),
('2018.09.22','Ботинки для сноуборда DC Mutiny Charocal', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae earum architecto repudiandae distinctio sapiente ad inventore cupiditate consequuntur est iste?', 'img/lot-4.jpg', '10999',  '2018.10.20', '1000', '0', '10999', '1', '3'),
('2018.09.23','Куртка для сноуборда DC Mutiny Charocal', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae earum architecto repudiandae distinctio sapiente ad inventore cupiditate consequuntur est iste?', 'img/lot-5.jpg', '7500', '2018.10.20', '1000', '0', '7500', '2', '4'),
('2018.09.24','Маска Oakley Canopy', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae earum architecto repudiandae distinctio sapiente ad inventore cupiditate consequuntur est iste?', 'img/lot-6.jpg', '5400', '2018.10.20', '5000', '0', '5400', '3', '6');

/* Добавляем ставки*/
INSERT INTO bets(date_craete, price, user_id, lot_id) VALUES
('2018.09.25', '10999', '1', '1'),
('2018.09.25', '159999', '3', '2'),
('2018.09.25', '8000', '2', '3'),
('2018.09.25', '10999', '2', '4'),
('2018.09.25', '7500', '1', '5');

/*получить все категории*/
SELECT * FROM categories;

/*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, количество ставок, название категории*/
SELECT title, price, image, price_now, bets_count, category_id FROM lots WHERE date_closed IS NULL ORDER BY date_craete DESC;

/*показать лот по его id. Получите также название категории, к которой принадлежит лот*/
SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = 1;

/*обновить название лота по его идентификатору*/
UPDATE lots SET title = "Новое название" WHERE id = 1;

/*получить список самых свежих ставок для лота по его идентификатору*/
SELECT * FROM bets WHERE lot_id = 1 ORDER BY date_craete DESC;
