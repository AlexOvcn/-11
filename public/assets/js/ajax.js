

let csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let dataElem = document.querySelector('meta[name="user"]');
let user_data;
if (dataElem !== null) {
    let data = dataElem.getAttribute('content');
    let dataArray = data.split(',');

    user_data = {               // глобальный обьект данных
        id: dataArray[0],
        role_id: dataArray[1]
    }
}


// добавление коммента под альбомом
function addComment(album_id) {
    let addCommentField = document.querySelector('#addCommentField');

    let filteredComment = addCommentField.value.replaceAll(/[^а-яА-Яa-zA-Z0-9]/ig,"");      // заменяем все символы кроме рус. англ. и цифр на пустоту

    if (filteredComment.length < 1) {
        addCommentField.style.cssText = 'border: 1px solid red; box-shadow: inset 0 0 20px 2px rgba(255, 0, 0, 0.185)';
        addCommentField.value = '';
        addCommentField.setAttribute('placeholder', 'Нужно здесь что-нибудь написать!');
        return;
    }

    let params = new FormData();
    params.set('_token', csrf_token);
    params.set('user_id', user_data.id);
    params.set('album_id', album_id);
    params.set('confirmed', user_data.role_id === '1' ? '0' : '1' );
    params.set('comment', filteredComment);

    fetch('http://127.0.0.1:8000/comment/store', {
        method: 'POST',
        mode: 'no-cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        body: params
    }).then(promise => {
        let btn_addComment = document.querySelector('#btn-addComment');
        btn_addComment.setAttribute('disabled', 'disabled');
        btn_addComment.classList.add('disabled');
        btn_addComment.classList.remove('btn-add');
        addCommentField.setAttribute('readonly', 'readonly');

        if (promise.ok) {

            addCommentField.setAttribute('style', '')

            if (user_data.role_id === '2') {
                addCommentField.value = 'Ваше сообщение добавлено!';
            } else {
                addCommentField.value = 'Ваше сообщение получено, и после одобрения администрацией появится здесь!';
            }

        } else {
            addCommentField.value = 'Кажется что-то пошло не так, ваше сообщение до нас не дошло!\nОшибка HTTP: ' + promise.status;
        }
    })
}

// прикрепление песни к альбому
let formAddSong = document.querySelector('#formAddSong');
let songsCounter = 1;
let songsArray = [];

if(formAddSong !== null) {
    formAddSong.addEventListener('submit', function (e){
        e.preventDefault();
        let form = e.target;

        let errorText = document.createElement('p');
        errorText.className = "errorText";
        errorText.textContent = 'Введите всю нужную информацию*';

        borderAddFromValidate(form.song_name);
        borderAddFromValidate(form.artist_id);
        borderAddFromValidate(form.song_text);

        let timeInp;
        if (!form.song_duration_minutes.value && !form.song_duration_seconds.value) {
            timeInp = false;
            borderAddFromValidate(form.song_duration_minutes);
            borderAddFromValidate(form.song_duration_seconds);
        } else {
            let minutesValue = validateInputTimeNext(form.song_duration_minutes.value);
            let secondsValue = validateInputTimeNext(form.song_duration_seconds.value);

            timeInp = `00:${minutesValue}:${secondsValue}`;
        }
        if (form.song_duration_minutes.value || form.song_duration_seconds.value) {
            borderAddFromValidate(form.song_duration_minutes, true);
            borderAddFromValidate(form.song_duration_seconds, true);
        }

        if (!form.song_name.value || !form.artist_id.value || !timeInp || !form.song_text.value) {
            let elem = form.querySelector('.errorText');
            if (elem === null) {
                form.append(errorText);
            }
            return;
        } else {
            let elem = form.querySelector('.errorText');
            if (elem !== null) {
                elem.remove();
            }
        }

        let params = new FormData(form);
        params.set('song_duration', timeInp);

        // for (key of params.keys()) {
        //     console.log(`${key}: ${params.get(key)}`);
        // } // позволяет посмотреть все ключи обьекта FormData

        fetch('http://127.0.0.1:8000/song/ajax_uniquenessOfSong', {
            method: 'POST',
            mode: 'no-cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/json'},
            body: params
        })
        .then((promise) => {
            promise.json().then(response => {
                errorText.textContent = 'Такая песня уже существует';
                if (response.unique) {
                    let elem = form.querySelector('.errorText');
                    if (elem !== null) {
                        elem.remove();
                    }

                    let songs_list = document.querySelector('#songs_list');
                    let emptyText = songs_list.querySelector('.songsList-empty');
                    if (emptyText !== null) {
                        emptyText.remove();
                    }
                    let songInfo = document.createElement('div');
                    songInfo.className = "songsList-songInfo flex-block down_border";
                    songInfo.innerHTML = `
                    <p class="song-item">${songsCounter++}</p>
                    <img class="song-item" src="${response.path_icon}" width="25px" style="margin-left: 10px">
                    <p class="song-item song-inAddAlbum">Название: ${response.song_name}</p>
                    <p class="song-item song-inAddAlbum">Исполнитель: ${response.artist_name}</p>
                    <p class="song-item song-inAddAlbum">Длительность: ${response.song_duration}</p>
                    `;
                    songs_list.append(songInfo);

                    let songItemArr = {
                        "song_name": response.song_name,
                        "artist_id": response.artist_id,
                        "song_duration": response.song_duration,
                        "song_text": response.song_text
                    };

                    songsArray.push(songItemArr);

                    form.song_name.value = '';
                    form.artist_id.value = '';
                    form.song_duration_minutes.value = '';
                    form.song_duration_seconds.value = '';
                    form.song_text.value = '';

                } else {
                    let elem = document.querySelector('.errorText');
                    if (elem === null) {
                        form.append(errorText);
                    }
                }
            })
        })
    })
}

// прикрепление песен к альбому и создание альбома
let formAddAlbum = document.querySelector('#formAddAlbum');

if(formAddAlbum !== null) {
    formAddAlbum.addEventListener('submit', function (e){
        e.preventDefault();
        let form = e.target;
        let btn = form.button;

        if (btn.classList.contains('btn-endClick')) {
            btn.classList.remove('btn-endClick');
        }
        btn.classList.add('btn-startClick');

        let errorText = document.createElement('p');
        errorText.className = "errorText";
        errorText.textContent = 'Введите всю нужную информацию*';

        borderAddFromValidate(form.album_name);
        borderAddFromValidate(form.artist_id);
        borderAddFromValidate(form.genre_id);
        borderAddFromValidate(form.release_date);

        if (!form.album_name.value || !form.artist_id.value || !form.genre_id.value || !form.release_date.value) {
            let elem = form.querySelector('.errorText');
            if (elem === null) {
                form.append(errorText);
            }
            return;
        } else {
            let elem = form.querySelector('.errorText');
            if (elem !== null) {
                elem.remove();
            }
        }
        if (!songsArray.length) {
            errorText.textContent = 'Закрепите хотя бы одну песню!';
            let elem = form.querySelector('.errorText');
            if (elem === null) {
                form.append(errorText);
            }
            return;
        } else {
            let elem = form.querySelector('.errorText');
            if (elem !== null) {
                elem.remove();
            }
        }

        let params = new FormData(form);

        // сейчас songsArray представляет из себя массив (для php он является индексным массивом) со значениями в виде обьектов, но нам нужен обьект с обьектами, чтобы провести сериализацию, буду использовать Object.fromEntries, который преобразует подобное..
        // [
        //     ['banana', 1],
        //     ['orange', 2],
        //     ['meat', 4]
        // ]
        // в { banana: 1, orange: 2, meat: 4 }, но для начала нам нужно пройтись по каждому элементу нашего массива songsArray и преобразовать каждый элемент в [индекс, обьект], нам поможет метод массива map
        let intermediateArray = songsArray.map((obj, index) => {
            return [index, obj];
        });     // то есть он создаст нов. массив в котором элементы из массива songsArray выглядят так...
        // [
        //     [0 , obj],
        //     [1 , obj],
        //     [2 , obj]    и т.д.
        // ]                            а это то что нам и нужно чтобы исп. Object.fromEntries

        let songsObj = Object.fromEntries(intermediateArray);   // теперь это обьект который выглядит так...
        // {
        //     0: obj,
        //     1: obj,
        //     2: obj       и т.д.
        // }

        songsObj = JSON.stringify(songsObj)     // сериализация обьекта js (так как FormData передает только строку)
        params.set('songs_obj', songsObj);

        fetch('http://127.0.0.1:8000/album', {
            method: 'POST',
            mode: 'no-cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/json'},
            body: params
        })
        .then((promise) => {
            promise.json().then(response => {
                errorText.textContent = 'Такой альбом уже существует';

                if (response.unique) {

                    if (btn.classList.contains('btn-startClick')) {
                        btn.classList.remove('btn-startClick');
                    }
                    btn.classList.add('btn-endClick');

                    let albumAddedText = document.createElement('p');
                    albumAddedText.className = "albumAddedText";
                    albumAddedText.setAttribute('style', 'color:green;margin-left:20px;display:inline-block');

                    if (user_data.role_id === '2') {
                        albumAddedText.textContent = `Альбом "${response.album_name}" был создан`;
                    } else {
                        albumAddedText.textContent = `Альбом "${response.album_name}" был создан и ждет одобрения`;
                    }

                    let elemSuccess = document.querySelector('.albumAddedText');
                    if (elemSuccess === null) {
                        form.append(albumAddedText);
                    }

                    // редирект через 3 секунды
                    let i = 2;
                    setTimeout(()=> {
                        setTimeout(function run() {
                            albumAddedText.textContent = `Переход на главную через ${i--}сек...`;
                            setTimeout(run, 1000);
                        }, 1000);
                    }, 1500);
                    setTimeout(function() {
                        window.location.href = `${response.redirect}`;
                    }, 4500);
                } else {
                    let elem = document.querySelector('.errorText');
                    if (elem === null) {
                        form.append(errorText);
                    }
                }
            })
        })
    })
}

// поиск альбома по введенным данным
function getAlbums(input) {

    let grid_container = document.querySelector('#grid_container');
    grid_container.innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';

    let params = new FormData();
    params.set('_token', csrf_token);
    params.set('text', input.value);

    fetch('http://127.0.0.1:8000/album/ajax_uniquenessOfSong', {
        method: 'POST',
        mode: 'no-cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        body: params
    }).then(promise => {
        promise.json().then(response => {

            grid_container.innerHTML = '';

            if (response.albums.length < 1) {
                grid_container.innerHTML = '<h3 class="notFoundAlbums">Не найдено ни одного альбома!</h3>';
            }

            // создание элементов грид контайнера (ссылок на альбомы)
            for (let i = 0; i < response.albums.length; i++) {
                let album = response.albums[i];
                let albumElem = document.createElement('a');
                albumElem.className = "grid-item grid-item__inGallery hidden";
                albumElem.setAttribute('href', response.album_url+"/"+album.id);
                albumElem.setAttribute('style', `background-image: url('${album.album_cover !== null ? response.img_url+"/"+album.album_cover : response.img_url_hasNot}')`);
                albumElem.innerHTML = `
                <p class="album-title album-title__inCover">${album.album_name}</p>
                <p class="album-artist album-artist__inCover">${album.artist_name}</p>
                `;
                if (grid_container !== null) {
                    grid_container.append(albumElem);
                }
            }

            // анимируем появление элементов
            let albumItem = document.querySelectorAll('.grid-item__inGallery');
            for (let i = 0; i < response.albums.length; i++) {
                setTimeout(()=> {
                    albumItem[i].classList.remove('hidden');
                    albumItem[i].classList.add('slowShow');
                    setTimeout(()=> {
                        albumItem[i].classList.remove('slowShow');
                    }, 220);
                }, i * 100);
            }
        })
    })
}

// одобрение определенного сообщения в панели админа
function messageConfirmation(btn, comment_id) {

    btn.classList.add('activeBtn');

    fetch(`http://127.0.0.1:8000/admin/comment_verdictConfirm/${comment_id}`, {
        // method: 'GET'       // тут так же как и в форме, если не указать метод, то будет использоватся GET
    }).then(promise => {

        if (promise.ok) {
            hideLinksCommentBlockForAdmin(btn, 'green');
        } else {
            console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
        }
    })
}

// удаление определенного сообщения в панели админа
function messageDelete(btn, comment_id) {

    btn.classList.add('activeBtn');

    fetch(`http://127.0.0.1:8000/admin/comment_verdictDelete/${comment_id}`, {
        method: 'GET'
    }).then(promise => {

        if (promise.ok) {
            hideLinksCommentBlockForAdmin(btn, 'red');
        } else {
            console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
        }
    })
}

// показ информации и элементов управления над пользователем
function showInfoOfUser(user_id) {
    let userPasport = document.querySelector('#userPasport');
    let actionsWithUser = document.querySelector('#actionsWithUser');

    if (user_id === '0') {

        if (userPasport.classList.contains('activeUserInfo')) {
            userPasport.classList.remove('activeUserInfo');
            userPasport.classList.add('notActiveUserInfo');
            actionsWithUser.classList.remove('activeUserInfo');
            actionsWithUser.classList.add('notActiveUserInfo');
        }
        return;
    }

    fetch(`http://127.0.0.1:8000/admin/user_showInfo/${user_id}`, {
        method: 'GET'
    }).then(promise => {
        if (promise.ok) {
            promise.json().then(response => {

                if (userPasport.classList.contains('hidden-userInfo')) {
                    userPasport.classList.add('activeUserInfo');
                    userPasport.classList.remove('hidden-userInfo');
                    actionsWithUser.classList.add('activeUserInfo');
                    actionsWithUser.classList.remove('hidden-userInfo');
                } else if (userPasport.classList.contains('notActiveUserInfo')) {
                    userPasport.classList.add('activeUserInfo');
                    userPasport.classList.remove('notActiveUserInfo');
                    actionsWithUser.classList.add('activeUserInfo');
                    actionsWithUser.classList.remove('notActiveUserInfo');
                }

                let date = new Date(response.user_info.created_at).toLocaleString();        // перевод серверного времени на местное

                let avatar = document.querySelector('#avatar');
                let name = document.querySelector('#name');
                let email = document.querySelector('#email');
                let status = document.querySelector('#status');
                let role = document.querySelector('#role');
                let created_at = document.querySelector('#created_at');

                avatar.setAttribute('style', `background-image: url('${response.user_avatar}')`);
                name.textContent = `${response.user_info.name}`;
                email.textContent = `${response.user_info.email}`;
                status.innerHTML = `Статус: <span style="color: ${response.user_info.status ? 'orangered' : 'yellowgreen'}">${response.user_info.status ? 'забанен' : 'активен'}</span>`;
                role.textContent = `${response.user_info.role.role}`;
                created_at.textContent = `${date}`;

                let firstButton = document.querySelector('#firstButton');
                let secondButton = document.querySelector('#secondButton');

                if (response.user_info.status) {
                    firstButton.outerHTML = `<a class="btn confirmation-btn mt-50" id="firstButton" onclick="actionsWithUser(0, ${response.user_info.id}, this)">Разблокировать</a>`;
                } else {
                    firstButton.outerHTML = `<a class="btn cancel-btn mt-50" id="firstButton" onclick="actionsWithUser(1, ${response.user_info.id}, this)">Заблокировать</a>`;
                }

                if (response.user_info.role_id === 2) {
                    secondButton.outerHTML = `<a class="btn cancel-btn mt-50" id="secondButton" onclick="actionsWithUser(2, ${response.user_info.id}, this)">Забрать админку</a>`;
                } else {
                    secondButton.outerHTML = `<a class="btn confirmation-btn mt-50" id="secondButton" onclick="actionsWithUser(3, ${response.user_info.id}, this)">Дать админку</a>`;
                }
            });
        } else {
            console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
        }
    })
}

// 4 действия над определенным пользователем (разблокировать, заблокировать, забрать админку, дать админку)
function actionsWithUser(action, user_id, btn) {

    if (btn.classList.contains('btn-endClick')) {
        btn.classList.remove('btn-endClick');
    }
    btn.classList.add('btn-startClick');

    fetch(`http://127.0.0.1:8000/admin/user_action/${action}/user/${user_id}`, {
        method: 'GET'
    }).then(promise => {
        if (promise.ok) {
            btn.classList.add('btn-endClick');
            showInfoOfUser(user_id);
        } else {
            console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
        }
    })
}

// обновление select с артистами
function refreshArtistSelect() {
    let artistSelect = document.querySelector('#artistSelectForDelete');

    fetch(`http://127.0.0.1:8000/admin/artist_select_refresh`, {
        method: 'GET'
    }).then(promise => {
        if (promise.ok) {
            promise.json().then(response => {

                artistSelect.innerHTML = '<option value="">Выберите исполнителя</option>';

                for (let i = 0; i < response.artists.length; i++) {
                    let artist = response.artists[i];

                    artistSelect.insertAdjacentHTML('beforeend', `<option value="${artist.id}">${artist.artist_name}</option>`);
                }
            })
        } else {
            console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
        }
    })
}

// удаление выбранного исполнителя
let formDeleteArtist = document.querySelector('#formDeleteArtist');

if(formDeleteArtist !== null) {
    formDeleteArtist.addEventListener('submit', function (e){
        e.preventDefault();
        let form = e.target;
        let artist_id = form.select.value;

        if (!artist_id) {
            return;
        }

        let btn = form.btn;

        if (btn.classList.contains('btn-endClick')) {
            btn.classList.remove('btn-endClick');
        }
        btn.classList.add('btn-startClick');

        fetch(`http://127.0.0.1:8000/admin/artist_delete/${artist_id}`, {
            method: 'GET'
        }).then(promise => {
            if (promise.ok) {
                if (btn.classList.contains('btn-startClick')) {
                    btn.classList.remove('btn-startClick');
                }
                btn.classList.add('btn-endClick');
                refreshArtistSelect();
            } else {
                console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
            }
        })
    });
}

// добавление исполнителя
let formAddArtist = document.querySelector('#formAddArtist');

if(formAddArtist !== null) {
    formAddArtist.addEventListener('submit', function (e){
        e.preventDefault();
        let form = e.target;
        let artistInput = form.input;

        let filteredArtistInput = artistInput.value.replaceAll(/[^а-яА-Яa-zA-Z0-9]/ig,"");      // заменяем все символы кроме рус. англ. и цифр на пустоту

        if (!filteredArtistInput) {
            artistInput.setAttribute('placeholder', 'Укажите имя');
            artistInput.value = '';

            if (!artistInput.classList.contains('red-border')) {
                artistInput.classList.add('red-border');
            }
            return;
        }

        let btn = form.btn;

        if (btn.classList.contains('btn-endClick')) {
            btn.classList.remove('btn-endClick');
        }
        btn.classList.add('btn-startClick');

        fetch(`http://127.0.0.1:8000/admin/artist_add/${filteredArtistInput}`, {
            method: 'GET'
        }).then(promise => {
            if (promise.ok) {
                if (btn.classList.contains('btn-startClick')) {
                    btn.classList.remove('btn-startClick');
                }
                btn.classList.add('btn-endClick');

                if (artistInput.classList.contains('red-border')) {
                    artistInput.classList.remove('red-border');
                }

                promise.json().then(response => {

                    if (response.status === 'Создан') {
                        refreshArtistSelect();
                        artistInput.value = '';
                    } else {
                        if (!artistInput.classList.contains('red-border')) {
                            artistInput.classList.add('red-border');
                        }
                        artistInput.value = 'Такой уже есть!';

                        setTimeout(() => {
                            artistInput.value = '';
                            artistInput.classList.remove('red-border');
                        }, 1500)
                    }

                    artistInput.setAttribute('placeholder', 'Имя исполнителя')
                });
            } else {
                console.log(`Запрос не дошел, код ошибки: ${promise.status}`);
            }
        })
    });
}
