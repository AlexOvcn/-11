//* Homework-25

//? функция конструктор создающая обьект из ключей переданного ей в аргумент обьекта с помощью оператора new

//! task1

function Automobile(obj) {
    this.color = obj.color;
    this.model = obj.model;
    this.year = obj.year;
    this.manufact = obj.manufact;
    this.whatColor = () => {
        return `Цвет машины: ${this.color}`;
    };
    this.autoInfo = function() {
        return `Модель машины: ${this.model}, Год выпуска: ${this.year}, Производитель автомобиля: ${this.manufact}`
    }
};

let firstCar = new Automobile ({
    model: 'Nissan',
    manufact: 'Skyline',
    year: '2007',
    color: 'Красный',
});
let secondCar = new Automobile ({
    model: 'Toyota',
    manufact: 'Corolla',
    year: '2009',
    color: 'Черный',
});
let thirdCar = new Automobile ({
    model: 'Volkswagen',
    manufact: 'Golf',
    year: '2009',
    color: 'Синий',
});

console.log(firstCar.whatColor());
console.log(secondCar.autoInfo());
console.log(thirdCar.autoInfo());

//! task2

let aboutMe = function(obj) {
    this.name = obj.name;
    this.age = obj.age;
    this.job = obj.job;
    this.who = () => {
        return `Я ${this.name} мне ${this.age} лет. Я работаю ${this.job}ом`
    };
};

let firstMan = new aboutMe({
    name: 'Дмитрий',
    age: '26',
    job: 'Дизайнер',
});
let secondMan = new aboutMe({
    name: 'Станислав',
    age: '29',
    job: 'Программист',
});
let thirdMan = new aboutMe({
    name: 'Сергей',
    age: '35',
    job: 'Менеджер',
});

console.log(firstMan.who())
console.log(secondMan.who())
console.log(thirdMan.who())

