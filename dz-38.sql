--? DZ-38

-- создание базы данных
CREATE DATABASE IF NOT EXISTS hospital;

-- создание таблицы
CREATE TABLE `hospital`.`patients` ( `id` INT NOT NULL AUTO_INCREMENT , `firstname` VARCHAR(30) NOT NULL , `lastname` VARCHAR(30) NOT NULL , `age` INT NOT NULL , `date_of_receipt` DATE NOT NULL , `date_of_discharge` DATE NULL , `department` VARCHAR(30) NOT NULL , `mobile_operator` VARCHAR(30) NOT NULL , `attending_doctor` VARCHAR(30) NOT NULL , `disease` VARCHAR(30) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- заполнение таблицы значениями
INSERT INTO `patients` (`id`, `firstname`, `lastname`, `age`, `date_of_receipt`, `date_of_discharge`, `department`, `mobile_operator`, `attending_doctor`, `disease`) VALUES (NULL, 'Олег', 'Кушеткин', '26', '2000-01-24', '2021-04-09', 'терапевтическое', 'utel', 'Лечилкин.Г.Ы', 'Имбицильность'), (NULL, 'Миранда', 'Пациентова', '10', '2011-06-15', NULL, 'хирургическое', 'ростелеком', 'Выручалкина.Й.Ъ', 'Депрессия'), (NULL, 'Даниил', 'Катетеровский', '52', '2019-01-04', '2019-01-19', 'терапевтическое', 'теле2', 'Лечилкин.Г.Ы', 'Депрессия'), (NULL, 'Станислав', 'Больных', '19', '2017-08-25', '2018-11-06', 'хирургическое', 'ростелеком', 'Выручалкина.Й.Ъ', 'Депрессия'), (NULL, 'Мишель', 'Каростовна', '28', '2021-02-23', '2021-07-16', 'хирургическое', 'utel', 'Выручалкина.Й.Ъ', 'Простуда'), (NULL, 'Роман', 'Простынкин', '91', '2021-04-12', '2021-04-13', 'терапевтическое', 'utel', 'Выручалкина.Й.Ъ', 'Усталось'), (NULL, 'Матвей', 'Мигренев', '42', '2020-09-12', '2021-01-24', 'терапевтическое', 'ростелеком', 'Лечилкин.Г.Ы', 'Депрессия'), (NULL, 'Василиса', 'Чесотовна', '22', '2020-12-21', '2021-01-03', 'гинекологическое', 'теле2', 'Выручалкина.Й.Ъ', 'Усталость'), (NULL, 'Зинаида', 'Матрасова', '43', '2020-11-01', '2021-01-04', 'гинекологическое', 'теле2', 'Выручалкина.Й.Ъ', 'Простуда'), (NULL, 'Инесса', 'Амебовна', '25', '2020-07-19', '2021-06-27', 'хирургическое', 'ростелеком', 'Лечилкин.Г.Ы', 'Бессонница'),(NULL, 'Георгий', 'Уткин', '42', '2018-01-24', '2018-02-25', 'хирургическое', 'utel', 'Лечилкин.Г.Ы', 'Депрессия');

-- запросы
--* 1) вывести информацию обо всех пациентах, находящихся в больнице
USE hospital;
SELECT * FROM patients;

--* 2) показать данные о пациентах, которые лежат в определенном отделении
USE hospital;
SELECT * FROM patients WHERE department = 'хирургическое';

--* 3) вывести названия всех отделений больницы
USE hospital;
SELECT department
FROM patients
GROUP BY department;

-- или 
USE hospital;
SELECT DISTINCT department
FROM patients;

--* 4) получить данные о пациентах, которые лежат в больнице больше месяца, отсортировав их по возрастанию даты поступления
USE hospital;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE (TIMESTAMPDIFF(month , date_of_receipt , date_of_discharge) > 0) OR (date_of_discharge IS NULL AND TIMESTAMPDIFF(month , date_of_receipt , CURDATE()) > 0)
ORDER BY date_of_receipt ASC;

--* 5) вывести информацию о пациентах, которые были выписаны в прошлом месяце 
USE hospital;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE MONTH(date_of_discharge) = MONTH(CURDATE())-1;

-- Или
WHERE (MONTH(CURDATE()) - MONTH(date_of_discharge)) = 1;

--* 6) информацию о пациентах, которые лежали в больнице с октября по декабрь прошлого года в определенном отделении
USE hospital;
SET @last_year = YEAR(CURDATE())-1;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE (CONCAT(@last_year, "-10-00") BETWEEN date_of_receipt AND date_of_discharge) AND (CONCAT(@last_year, "-12-00") BETWEEN date_of_receipt AND date_of_discharge) AND disease = 'Депрессия'

--* 7) вывести информацию о самом молодом пациенте 
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients
ORDER BY age ASC
LIMIT 1;

--* 8) получить информацию о пациентах, которые лежат в любых двух отделениях
USE hospital;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE department IN("гинекологическое", "терапевтическое");

--* 9) показать всех пациентов, фамилия которых начинается на букву К
USE hospital;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE lastname LIKE 'К%';

--* 10) вывести данные о пациентах, которых лечит определенный врач с одинаковыми заболеваниями
USE hospital;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE attending_doctor = 'Лечилкин.Г.Ы' AND disease = 'Депрессия';

--* 11) получить данные о пациентах, пользующихся услугами определенного мобильного оператора
USE hospital;
SELECT id, firstname, lastname, age, date_of_receipt, date_of_discharge, department, mobile_operator, attending_doctor, disease
FROM patients 
WHERE mobile_operator = 'ростелеком';

--* 12) переименовать название определенного отделения
USE hospital;
UPDATE `patients` 
SET `department` = 'моечное' 
WHERE `patients`.`department` = 'хирургическое';

--* 13) удалить всех пациентов, которые были выписаны больше, чем полгода назад
USE hospital;
DELETE FROM `patients` 
WHERE TIMESTAMPDIFF(month , date_of_discharge , CURDATE()) > 5;