//* Homework-19 (Плагин "Better Comments" для VSCode - разделяет различные типы комментариев цветом)

//? Виды консольных ошибок

/*
const typeError = () => {
    const error = 10;
    return error()
}
console.log(typeError());
*/

/*
const syntaxError  = () => {
    const error = 10,
    return error
}
console.log(syntaxError());
*/

/*
const referenceError  = () => {
    const error = 10;
    return eerrok
}
console.log(referenceError());
*/

/*
const logicError  = () => {
    const productOfTwoNumbers = 1 + 2 * 5 - 3;
    return productOfTwoNumbers
}
console.log(logicError());
*/

//? Способы выполнения задачи с рекурсией

//! Использование конструкции if...else

const taskTwoA = (n) => {
    const sumOfSquaresOfNaturalNumbers = (num) => {
        if (num === 1) {
            return 1
        } else {
            return (num) ** 2 + sumOfSquaresOfNaturalNumbers(num - 1)
        }
        /* Или можно опустить инструкцию else
        if (num === 1) {
            return 1
        }
        return (num) ** 2 + sumOfSquaresOfNaturalNumbers(num - 1)
        */
    }
    const squareOfTheSumOfNaturalNumbers = (num) => {
        if (num === 0) {
            return 0
        } else {
            return num + squareOfTheSumOfNaturalNumbers(num - 1)
        }
        /* Или...
        if (num === 0) {
            return 0
        }
        return num + squareOfTheSumOfNaturalNumbers(num - 1)
        */
    }
    const differencBetweenTwoNumbers = (n) => {
        return (squareOfTheSumOfNaturalNumbers(n) ** 2) - sumOfSquaresOfNaturalNumbers(n)
    }
    return differencBetweenTwoNumbers(n)
}
console.log("TaskTwo version A: " + taskTwoA(10))

//! Использование оператора switch

const taskTwoB = (n) => {
    const sumOfSquaresOfNaturalNumbers = (num) => {
        switch (num) {
            case 1:
                return 1;
                break;
            default:
                return (num) ** 2 + sumOfSquaresOfNaturalNumbers(num - 1)
        }
        /* Или в аргумент оператора выставить постоянное true, а в случаях вписывать выражения
        switch (true) {
            case num <= 1:
                return 1;
                break;
            default:
                return (num) ** 2 + sumOfSquaresOfNaturalNumbers(num - 1)
        }
        */
    }
    const squareOfTheSumOfNaturalNumbers = (num) => {
        switch (num) {
            case 0:
                return 0;
                break;
            default:
                return num + squareOfTheSumOfNaturalNumbers(num - 1)
        }
        /* Или...
        switch (true) {
            case num <= 0:
                return 0;
                break;
            default:
                return num + squareOfTheSumOfNaturalNumbers(num - 1)
        }
        */
    }
    const differencBetweenTwoNumbers = (n) => {
        return (squareOfTheSumOfNaturalNumbers(n) ** 2) - sumOfSquaresOfNaturalNumbers(n)
    }
    return differencBetweenTwoNumbers(n)
}
console.log("TaskTwo version B: " + taskTwoB(10))

//! Использование тернарного оператора

const taskTwoC = (n) => {
    const sumOfSquaresOfNaturalNumbers = (num) => {
        const sumOfSquares = num <= 1 ? 1 : (num) ** 2 + sumOfSquaresOfNaturalNumbers(num - 1)
        return sumOfSquares
    }
    const squareOfTheSumOfNaturalNumbers = (num) => {
        const squareOfTheSum = num <= 0 ? 0 : num + squareOfTheSumOfNaturalNumbers(num - 1)
        return squareOfTheSum
    }
    const differencBetweenTwoNumbers = (n) => {
        return (squareOfTheSumOfNaturalNumbers(n) ** 2) - sumOfSquaresOfNaturalNumbers(n)
    }
    return differencBetweenTwoNumbers(n)
}
console.log("TaskTwo version C: " + taskTwoC(10))

//! Использование цикла (инструкция for)

const taskTwoD = (n) => {
    const sumOfSquaresOfNaturalNumbers = (num) => {
        let sum = 0;
        for (num; num >= 1; num--) {
            sum += (num) ** 2
        }
        return sum
        /* С использованием массива
        array = [];
        for (num; num >= 1; num--) {
            array[num - 1] = (num) ** 2
        }
        return array.map(i => x += i, x = 0).reverse()[0]
        */
    }
    const squareOfTheSumOfNaturalNumbers = (num) => {
        let sum = 0;
        for (num; num >= 0; num--) {
            sum += num
        }
        return sum
        /* Или...
        array = [];
        for (num; num >= 1; num--) {
            array[num - 1] = num
        }
        return array.map(i => x += i, x = 0).reverse()[0]
        */
    }
    const differencBetweenTwoNumbers = (n) => {
        return (squareOfTheSumOfNaturalNumbers(n) ** 2) - sumOfSquaresOfNaturalNumbers(n)
    }
    return differencBetweenTwoNumbers(n)
}
console.log("TaskTwo version D: " + taskTwoD(10))