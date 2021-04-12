//? Homework-18

const taskOne = (a, b, c, d, e) => {
    let expressionResult = (a * (b + c)) / (d + c);
    let expression = "(" + a + " * " + "(" + b + " + " + c + ")" + ")" + " / " + "(" + d + " + " + e + ")";
    let task = expression + " = " + expressionResult;
    console.log("TaskOne:")
    console.log(task)
};
taskOne(55, 7, 2, 4, 2);
console.log(" ")


let name = "Alexandr";
const yearOfBirth = 1998;
const taskTwo = (name) => {
    console.log("TaskTwo:")
    return "Hello " + name
};
console.log(taskTwo(name))
console.log(" ")


const TaskThree = {
    average(a, b) {
        console.log ("TaskThree:")
        let arrayOfAverage = [a, b];
        let expression = "(" + a + " + " + b + ")" + " / " + arrayOfAverage.length;
        return " *Average of two numbers: " + expression + " = " + (a + b) / arrayOfAverage.length
    },
    square(a) {
        let squareOfNumber = (a) **2
        let expression = "(" + a + ")^2"
        return " *Square of number: " + expression + " = " + squareOfNumber
    },
    cube(a) {
        let numberInCube = (a) **3
        let expression = "(" + a + ")^3"
        return " *Number in the cube: " + expression + " = " + numberInCube
    },
};
console.log(TaskThree.average(6, 8))
console.log(TaskThree.square(7))
console.log(TaskThree.cube(7))
console.log(" ")


const TaskFour = {
    arrayTaskFour: [],
    square(a) {
        return (a) **2
    },
    cube(a) {
        return (a) **3
    },
    average(a, b) {
        return (a + b) / 2
    },
    calculate() {
        for (let i = 0; i <= 9; i++) {
            a = TaskFour.square(i);
            b = TaskFour.cube(i);
            TaskFour.arrayTaskFour[i] = TaskFour.average(a, b);
        }
        console.log("TaskFour:")
        return TaskFour.arrayTaskFour
    },
}
console.log(TaskFour.calculate())