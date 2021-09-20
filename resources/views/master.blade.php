<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=500, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <title>@yield('page')</title>
</head>
<body>
    @yield('content')
    <script>
        function inputRestriction(maxValue, thisInput) {
            let minValue = 2;
            if (thisInput.value.match(/\s{2,}/)) {
                thisInput.value = thisInput.value.trim()+' ';
            }
            if (maxValue < thisInput.value.length || minValue > thisInput.value.length) {
                thisInput.value = thisInput.value.slice(0, maxValue);
                if (!thisInput.classList.contains('redInput')) {
                    thisInput.classList.add('redInput');
                }
            } else if (maxValue >= thisInput.value.length) {
                if (thisInput.classList.contains('redInput')) {
                    thisInput.classList.remove('redInput');
                }
            }
        }
        function localDate(sourceDate) {
            // обрабатываем исключение
            if (sourceDate === 'дата не задана') {
                return 'дата не задана';
            }
            // разделяем полученную строку даты из php и упаковываем в массив
            let changingDateFormat = sourceDate.split(/[-: ]/);
            // создаем экземпляр даты с временем из php
            let dateOfServer = new Date(...changingDateFormat);
            // получаем utc на клиенте в минутах(изнчально значение инверсировано)
            let utc = new Date().getTimezoneOffset();
            utc = -utc;
            // изменяем серверную дату с имеющимся utc клиента(setMinutes имеет формат времени Unix)
            setMinutes = dateOfServer.setMinutes(dateOfServer.getMinutes() + utc );
            date = new Date(setMinutes);
            // редактируем формат времени полученный в JS (например 2012-1-9 9:12:1 => 2012-01-09 09:12:01)
            let getDateForPHP = (date) => {
                function addingZero(num) {
                    if (String(num).length === 1) {
                        num = `0${num}`;
                    }
                    return num;
                }
                let year = date.getFullYear();
                let month = date.getMonth();
                month = addingZero(month);
                let day = date.getDate();
                day = addingZero(day);
                let hours = date.getHours();
                hours = addingZero(hours);
                let minutes = date.getMinutes();
                minutes = addingZero(minutes);
                let seconds = date.getSeconds();
                seconds = addingZero(seconds);
                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }
            return getDateForPHP(date);
        }
    </script>
</body>
</html>
