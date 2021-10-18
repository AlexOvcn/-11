

// показ текста песни
function show_songText(id) {
    let elem = document.querySelector('#song-text'+id);
    let elemShowText = document.querySelector('#song-showText'+id);

    elemShowText.classList.add('song-showTextOfSongAnim');
    setTimeout(()=> {
        elemShowText.classList.remove('song-showTextOfSongAnim');
    }, 500)

    if (elem.classList.contains('songText-hidden')) {
        elem.classList.remove('songText-hidden');
        elem.classList.add('songText-show');
        setTimeout(()=> {
            elemShowText.textContent = 'Скрыть текст песни ⮝';
        }, 250)
    }
    else if (elem.classList.contains('songText-show')) {
        elem.classList.remove('songText-show');
        elem.classList.add('songText-hidden');
        setTimeout(()=> {
            elemShowText.textContent = 'Посмотреть текст песни ⮟';
        }, 250)
    }
}

// перевод серверного времени на местное
function localDate(sourceDate) {
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

// добавление красного бордера при валидации
function borderAddFromValidate(elem, status = false) {
    if (status) {
        if (elem.classList.contains('red-border')) {
            elem.classList.remove('red-border');
        }
        return;
    }
    if (!elem.value) {
        if (!elem.classList.contains('red-border')) {
            elem.classList.add('red-border');
        }
    } else {
        if (elem.classList.contains('red-border')) {
            elem.classList.remove('red-border');
        }
    }
}


document.addEventListener('DOMContentLoaded', function(){

    // добавление обработанного времени (согласно локальному времени) в элемент "#comment_sendingTime"
    let sendingTimeElements = document.querySelectorAll('.comment-info__sendingTime');

    if (sendingTimeElements.length !== 0) {

        sendingTimeElements.forEach((sendingTimeElement) => {

            let valueSendingTime = sendingTimeElement.getAttribute('value');
            let newValueSendingTime = localDate(valueSendingTime);
            sendingTimeElement.insertAdjacentText("beforeend", newValueSendingTime)
        })
    }

    // валидация блока добавления комментария
    let addCommentField = document.querySelector('#addCommentField');

    if (addCommentField !== null) {
        addCommentField.addEventListener('input', function(elem){
            if (elem.target.value.length < 1) {
                elem.target.style.cssText = 'border: 1px solid red; box-shadow: inset 0 0 20px 2px rgba(255, 0, 0, 0.185)';
            } else if (elem.target.value.length > 570) {
                elem.target.style.cssText = 'border: 1px solid red; box-shadow: inset 0 0 20px 2px rgba(255, 0, 0, 0.185)';
                elem.target.value = elem.target.value.slice(0, 570)
            } else {
                elem.target.style.cssText = '';
            }
        })
    }

    // валидация инпута длительности трека при добавлении трека в альбом
    let song_duration = document.querySelector('#song_duration');

    if (song_duration !== null) {
        let song_duration_minutes = document.querySelector('#song_duration_minutes');
        let song_duration_seconds = document.querySelector('#song_duration_seconds');

        let validateInputTime = function(elem) {
            elem.target.value = elem.target.value.slice(0, 2);
            let pattern = /^[0-5]{0,1}[0-9]{0,1}$/g;

            if (!pattern.test(elem.target.value)) {
                elem.target.value = '';
            }
            if(elem.target.value.length === 2) {
                song_duration_seconds.focus();
            }
        }
        song_duration_minutes.addEventListener('input', function(elem){
            validateInputTime(elem);
        });
        song_duration_seconds.addEventListener('input', function(elem){
            validateInputTime(elem);
        });
    }

    // валидация инпута по добавлению исполнителя
    let inputFromFormAddArtist = document.querySelector('#inputFromFormAddArtist');

    if (inputFromFormAddArtist !== null) {
        inputFromFormAddArtist.addEventListener('input', function(e) {

            if (!e.target.value) {

                if (!e.target.classList.contains('red-border')) {
                    e.target.classList.add('red-border');
                }
            } else {
                if (e.target.classList.contains('red-border')) {
                    e.target.classList.remove('red-border');
                }
            }

            if (e.target.value.length > 20) {
                e.target.value = e.target.value.slice(0, 20);

                if (!e.target.classList.contains('red-border')) {
                    e.target.classList.add('red-border');
                }
            }
        })
    }
});

// валидация инпута длительности трека при добавлении трека в альбом, далее из формы
function validateInputTimeNext(value) {

    if (value.length < 1) {
        value = '00';
    }
    if (value.length < 2) {
        value = '0' + value;
    }
    return value;
}

// медленное затемнение экрана
function darkScreenShow() {

    let darkScreenShow = document.createElement('div');
    let body = document.querySelector('body');
    darkScreenShow.className = "darkScreenShow";
    if (body !== null) {
        body.append(darkScreenShow);
    }
}

// анимация исчезновения карточек с комментами в (админ панели > неподтвержденные комментарии)
function hideLinksCommentBlockForAdmin(btn, color) {

    let elem = btn.closest('.commentBlockFromAdmin');

    if (color === 'green') {
        elem.classList.add('slowHidden-commentBlockFromAdminConf');
    }
    if (color === 'red') {
        elem.classList.add('slowHidden-commentBlockFromAdminCanc');
    }

    // создание уведомления о пустом стеке сообщений
    function emptyText() {
        let commentBlockFromAdmin = document.querySelectorAll('.commentBlockFromAdmin');

        if (commentBlockFromAdmin.length < 1) {
            let emptyTextExist = document.querySelector('.commentBlockFromAdmin-notHas');

            if (emptyTextExist === null) {
                let container = document.querySelector('.container');
                let emptyText = document.createElement('p');

                emptyText.innerHTML = 'Вы проверили все сообщения!';
                emptyText.className = "commentBlockFromAdmin-notHas";
                container.append(emptyText);
            }
        }
    }

    // асинхронный запуск проверки пустоты стека сообщений после удаления элемента
    new Promise((resolve) => {
        setTimeout(() => {
            elem.remove();
            resolve();
        }, 1100)
    }).then(() => {
        emptyText();
    })
}
