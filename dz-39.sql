--? DZ-39

-- создание базы данных
CREATE DATABASE IF NOT EXISTS fitness_club;

-- создание таблиц
USE fitness_club;
CREATE TABLE `fitness_club`.`instructors` ( `id` INT NULL AUTO_INCREMENT , `firstname` VARCHAR(20) NOT NULL, `lastname` VARCHAR(20) NOT NULL, `id_sports_section` TINYINT NOT NULL, `start_of_shift` TIME(6) NOT NULL, `end_of_shift` TIME(6) NOT NULL, INDEX (`id_sports_section`), PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `fitness_club`.`sports_sections` ( `id` TINYINT NOT NULL AUTO_INCREMENT , `section_name` VARCHAR(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `fitness_club`.`list_of_visits` ( `id` INT NOT NULL , `1st_quarter_2020` INT NOT NULL , `2nd_quarter_2020` INT NOT NULL , `3rd_quarter_2020` INT NOT NULL , `4th_quarter_2020` INT NOT NULL , `1st_quarter_2021` INT NOT NULL , `2nd_quarter_2021` INT NOT NULL , `3rd_quarter_2021` INT NOT NULL , `4th_quarter_2021` INT NOT NULL , INDEX (`id`)) ENGINE = InnoDB;

CREATE TABLE `fitness_club`.`visitors` ( `id` INT NOT NULL AUTO_INCREMENT , `firstname` VARCHAR(20) NOT NULL , `lastname` VARCHAR(20) NOT NULL , `instructor_id` INT NOT NULL , `mobile_operator` VARCHAR(20) NULL , PRIMARY KEY (`id`), INDEX (`instructor_id`)) ENGINE = InnoDB;

-- заполнение таблиц значениями
USE fitness_club;
INSERT INTO `sports_sections` (`id`, `section_name`) VALUES (NULL, 'Пауэрлифтинг'), (NULL, 'Бодибилдинг'), (NULL, 'Аэробика'), (NULL, 'Шейпинг');

INSERT INTO `instructors` (`id`, `firstname`, `lastname`, `id_sports_section`, `start_of_shift`, `end_of_shift`) VALUES (NULL, 'Илья', 'Гантелев', '1', '16:00', '21:00'), (NULL, 'Светлана', 'Приседайкина', '3', '12:00', '18:00'), (NULL, 'Анна', 'Попрыгушкина', '4', '14:00', '20:00'), (NULL, 'Артемий', 'Жимлёжев', '2', '17:00', '21:00'), (NULL, 'Александр', 'Грифель', '2', '12:00', '18:00');

INSERT INTO `visitors` (`id`, `firstname`, `lastname`, `instructor_id`, `mobile_operator`) VALUES (NULL, 'Арсений', 'Задохлишев', '4', 'utel'), (NULL, 'Ярослава', 'Жирненьких', '3', 'ростелеком'), (NULL, 'Дарина', 'Бледная', '2', 'ростелеком'), (NULL, 'Леонид', 'Немощных', '5', 'Радуга'), (NULL, 'Федор', 'Слабачков', '1', 'теле2'), (NULL, 'Виталий', 'Хилач', '1', 'utel'), (NULL, 'Анжела', 'Потных', '3', 'радуга'), (NULL, 'Леонид', 'Дряхлый', '5', 'теле2'), (NULL, 'Михаил', 'Убогов', '5', 'теле2'), (NULL, 'Ева', 'Пухлых', '3', 'ростелеком');

INSERT INTO `list_of_visits` (`id`, `1st_quarter_2020`, `2nd_quarter_2020`, `3rd_quarter_2020`, `4th_quarter_2020`, `1st_quarter_2021`, `2nd_quarter_2021`, `3rd_quarter_2021`, `4th_quarter_2021`) VALUES ('1', '12', '6', '2', '20', '13', "0", '0', '0'), ('2', "0", "0", '10', '24', "0", '17', '0', "0"), ('3', "0", "0", "0", "0", '20', '12', '0', '0'), ('4', '10', '14', '42', '12', "0", "0", "0", "0"), ('5', "0", "0", '1', "0", '2', "0", "0", '0'), ('6', '3', '12', '4', '25', '14', '36', '0', '0'), ('7', '12', '2', "0", "0", '1', "0", '0', "0"), ('8', "0", "0", "0", "0", '23', "0", '0', "0"), ('9', '20', "0", "0", '23', "0", "0", "0", "0"), ('10', "0", '18', '12', "0", '27', '2', "0", "0");

-- связывание таблиц
USE fitness_club;
ALTER TABLE `instructors` ADD FOREIGN KEY (`id_sports_section`) REFERENCES `sports_sections`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `visitors` ADD FOREIGN KEY (`instructor_id`) REFERENCES `instructors`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `list_of_visits` ADD FOREIGN KEY (`id`) REFERENCES `visitors`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--запросы
--* 1) вывести количество инструкторов по каждой секции
USE fitness_club;
SELECT COUNT(*) AS "number of instructors", SS.section_name
FROM instructors AS I, sports_sections AS SS
WHERE I.id_sports_section = SS.id
GROUP BY SS.section_name;

--* 2) показать количество людей, которые должны заниматься в определенный момент времени в каждой секции (люди, то есть вместе с инструктором)
USE fitness_club;
SET @time = '15:00';
SELECT COUNT(*) AS "number of people", @time AS "TIME", SS.section_name
FROM visitors AS V, sports_sections AS SS, instructors AS I
WHERE V.instructor_id = I.id AND I.id_sports_section = SS.id AND (@time BETWEEN I.start_of_shift AND I.end_of_shift)
UNION
SELECT COUNT(*) AS "number of people", @time AS "TIME", SS.section_name
FROM instructors AS I, sports_sections AS SS
WHERE I.id_sports_section = SS.id AND (@time BETWEEN I.start_of_shift AND I.end_of_shift);

-- или только посетители
USE fitness_club;
SET @time = '15:00';
SELECT COUNT(*) AS "number of visitors", @time AS "TIME", SS.section_name
FROM visitors AS V, sports_sections AS SS, instructors AS I
WHERE V.instructor_id = I.id AND I.id_sports_section = SS.id AND (@time BETWEEN I.start_of_shift AND I.end_of_shift)
GROUP BY SS.section_name;

--* 3) вывести количество посетителей фитнес клуба, которые пользуются услугами определенного мобильного оператора
USE fitness_club;
SELECT COUNT(V.id) AS "number of visitors", V.mobile_operator
FROM visitors AS V
WHERE mobile_operator = 'utel';

--* 4) получить количество посетителей, у которых фамилия совпадает с фамилиями из определенного списка
USE fitness_club;
SET collation_connection = utf8_unicode_ci;
SET @surname1 = 'Задохлишев', @surname2 = 'Бледная';
SELECT COUNT(V.id) AS "number of visitors"
FROM visitors AS V
WHERE lastname LIKE @surname1 OR lastname LIKE @surname2;

-- без этой строчки появляется ошибка (SET collation_connection = utf8_unicode_ci) все из-за того что автоматически ставится сравнение - (utf8mb4_general_ci), но если самостоятельно в БД изменить его на (utf8_unicode_ci) проблема решится

--* 5) показать количество посетителей с одинаковыми именами, которые занимаются у определенного инструктора
USE fitness_club;
SET collation_connection = utf8_unicode_ci;
SET @instrLastname = 'Грифель', @visitorsName = 'Леонид';
SELECT COUNT(V.id) AS "number of visitors", @instrLastname AS "instructor's name"
FROM visitors AS V, instructors AS I
WHERE V.instructor_id = I.id AND V.firstname LIKE @visitorsName AND I.lastname LIKE @instrLastname;

--* 6) получить информацию о людях, которые посетили фитнес-зал минимальное количество раз
USE fitness_club;
SELECT V.id, V.firstname, V.lastname, V.instructor_id, V.mobile_operator, (1st_quarter_2020+2nd_quarter_2020+3rd_quarter_2020+4th_quarter_2020+1st_quarter_2021+2nd_quarter_2021+3rd_quarter_2021+4th_quarter_2021) AS "number of visits"
FROM visitors AS V, list_of_visits AS LV
WHERE (1st_quarter_2020+2nd_quarter_2020+3rd_quarter_2020+4th_quarter_2020+1st_quarter_2021+2nd_quarter_2021+3rd_quarter_2021+4th_quarter_2021) <= 30 AND V.id = LV.id
GROUP BY V.id;

--* 7) вывести количество посетителей, которые занимались в определенной секции за первую половину текущего года
USE fitness_club;
SELECT COUNT(V.id) AS "number of visitors", SS.section_name
FROM visitors AS V, sports_sections AS SS, instructors AS I, list_of_visits AS LV
WHERE V.id = LV.id AND V.instructor_id = I.id AND I.id_sports_section = SS.id AND (LV.1st_quarter_2021+LV.2nd_quarter_2021) >=1
GROUP BY SS.section_name;

--* 8) определить общее количество людей, посетивших фитнес-зал за прошлый год
USE fitness_club;
SELECT COUNT(V.id) AS "number of visitors"
FROM visitors AS V, list_of_visits AS LV
WHERE V.id = LV.id AND (LV.1st_quarter_2020+LV.2nd_quarter_2020+LV.3rd_quarter_2020+LV.4th_quarter_2020) >=1