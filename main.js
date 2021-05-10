//* Homework-21

//? task 1 |функция, которая определяет, является ли переданное число натуральной степенью тройки. Например, число 27 — это третья степень: 3^3, а 81 — это четвёртая: 3^4.

let thisNumberIsNaturalDegreeFromThree = function(num) {
    if (num % 3 == 0) {
        let degree = ''
        for (i = 2; num > 3; i++) {
            num = num / 3
            degree = i.toString()
        }
        let endOfTheWord = ''
        if ((degree[degree.length - 1] == 3) && (degree[degree.length - 2] != 1)) {
            endOfTheWord = 'ей'
        } else {
            endOfTheWord = 'ой'
        }
        return `Это число является ${degree}${endOfTheWord} степенью тройки`
    }
    return 'Это число не является натуральной степенью тройки'
} 

console.log(thisNumberIsNaturalDegreeFromThree(27))

//? task 2 |функция, которая переворачивает цифры в переданном числе и возвращает новое число.

//! декларативный способ решения
let reverseInt1 = (...int) => console.log(int.filter(i => i != 0).length == 0 ? 'Empty' : int.filter(i => i != 0).reverse().reduce((acc , key) => acc += key.toString()).toString())

reverseInt1(2, 7, 3)
// reverseInt1(0, 0)
// reverseInt1(0, -2, 0)

//! более императивный способ решения
let reverseInt2 = (...int) => {
    let reverseMassiv = ''
    for (key in int) {
        reverseMassiv += int[Math.abs(key - (int.length - 1))]
    }
    let result = ''
    for (i = 0; i <= reverseMassiv.length - 1; i++) {
        if (reverseMassiv[i] == 0) {
            continue
        }
        result += reverseMassiv[i]
    }
    if (result.length == 0) {
        console.log('Empty')
        return
    }
    console.log(result)
}

reverseInt2(2, 7, 3)
// reverseInt2(0, 0)
// reverseInt2(0, -2, 0)

//? task 3 |функция, которая выводит (console.log) в терминал числа в диапазоне от begin до end. При этом:
// * Если число делится без остатка на 3, то вместо него выводится слово Fizz
// * Если число делится без остатка на 5, то вместо него выводится слово Buzz
// * Если число делится без остатка и на 3, и на 5, то вместо числа выводится слово FizzBuzz
// * В остальных случаях выводится само число

const FizzBuzz = function(begin, end) {
    let res = ''
    let expression = function(begin, end) {
        fb = ''
            if (i % 3 == 0 && i % 5 == 0) {
                fb = 'FizzBuzz'
                res += fb.toString() + ','
                return
            } else if (i % 5 == 0) {
                fb = 'Buzz'
                res += fb.toString() + ','
                return
            } else if (i % 3 == 0) {
                fb = 'Fizz'
                res += fb.toString() + ','
                return
            }
            res += i.toString() + ','
    }
    if (begin > end) {
        for (i = end; i <= begin; i++) {
            expression()
        }
    } else if (begin < end) {
        for (i = begin; i <= end; i++) {
            expression()
        }
    }
    console.log(res.substring(0,res.length - 1))
}

FizzBuzz(0, 15)


//? task 4 |функция, которая принимает на вход цепь ДНК и возвращает соответствующую цепь РНК (совершает транскрипцию РНК).Если во входном параметре нет ни одного нуклеотида (т.е. передана пустая строка), то функция должна вернуть пустую строку. Если в переданной цепи ДНК встретится "незнакомый" нуклеотид (не являющийся одним из четырех перечисленных выше), то функция должна вернуть null.
// * G -> C
// * C -> G
// * T -> A
// * A -> U

let dnaToRna = (string) => {
    if (string.length == 0) {
        console.log('Empty')
        return
    }
    let patternOne = /[GCTA]/g
    let patternTwo = /[^GCTA]/g
    let massiv = string.match(patternOne)
    let contentExclusion = string.match(patternTwo)
    if (contentExclusion != null) {
        console.log('null')
        return
    }
    let res = ''
    let expression = function(key) {
        res += key
    }
    for (key of massiv) {
        if (key == 'G'){
            key = 'C'
            expression(key)
        } else if (key == 'C') {
            key = 'G'
            expression(key)
        } else if (key == 'T') {
            key = 'A'
            expression(key)
        } else if (key == 'A') {
            key = 'U'
            expression(key)
        }
    }
    console.log(res)
}

dnaToRna('ACGTGGTCTTAA')
// dnaToRna('CCGTA')
// dnaToRna('')
// dnaToRna('ACNTG')

