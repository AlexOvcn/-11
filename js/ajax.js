/* Функция вывода выпадающего списка городов */
function show(id) {
    if (id.classList.contains('hiddenInput')) {
        id.classList.remove('hiddenInput');
        id.classList.add('slowShowing');
    }
}
function remove(id) {
    if (id.classList.contains('slowShowing')) {
        id.classList.add('hiddenInput');
        id.classList.remove('slowShowing');
    }
}

function showCities(country_id) {
    let c = document.getElementById('city_list');
    let h = document.getElementById('h');
    let hotel_list = document.getElementById('hotel_list');
    let id_textarea_comment = document.getElementById('textarea_comment');
    let id_btn_comment_add = document.getElementById('btn_comment_add');
    /* Медленное появления инпута с городами */
    show(c);
    /* Если ничего не выбрано, убираем выпадающие списки и другие эл. если таковые видны */
    if (country_id === "") {
        remove(c);
        remove(hotel_list);
        remove(id_textarea_comment);
        remove(id_btn_comment_add);
        return;
    }
    if (hotel_list !== null) {
        hotel_list.innerHTML = '<option value=""><-Выберите город</option>';
    }
    if (country_id === "t") {
        c.outerHTML = '<select name="city_id" id="city_list" class="form-control btn-warning hiddenInput border-warning bg-light" onchange="showHotels(this.value)"></select>';
        h.innerHTML = "";
        return;
    }
    /* Создаем AJAX-объект */
    if (window.XMLHttpRequest) {
        ao = new XMLHttpRequest();
    } else {
        ao = new ActiveXObject('Microsoft.XMLHTTP');
    }

    /* Создаем функцию для приема результата запроса */
    ao.onreadystatechange = function () {
        /* Если операция завершена (4) и статус ответа 200, выводим список городов */
        if (ao.readyState == 4 && ao.status == 200) {
            c.innerHTML = ao.responseText;
        }
    }

    /* Создаем и отправляем AJAX-запрос методом GET */
    ao.open('GET', "pages/ajax_cities.php?cid=" + country_id, true);
    ao.send(null);
}

/* Функция вывода списка отелей */
function showHotels(city_id) {
    let h = document.getElementById('h');
    if (city_id === "") {
        h.innerHTML = "";
        return;
    }

    /* Создаем AJAX-объект */
    if (window.XMLHttpRequest) {
        ao = new XMLHttpRequest();
    } else {
        ao = new ActiveXObject('Microsoft.XMLHTTP');
    }

    /* Создаем функцию для приема результата запроса */
    ao.onreadystatechange = function () {
        /* Если операция завершена (4) и статус ответа 200, выводим список городов */
        if (ao.readyState == 4 && ao.status == 200) {
            h.innerHTML = ao.responseText;
        }
    }
    /* Создаем и отправляем AJAX-запрос методом POST */
    ao.open("POST", "pages/ajax_hotels.php", true);
    ao.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
    ao.send("cid=" + city_id);
}

function showHotels_list(city_id) {
    let hotel_list = document.getElementById('hotel_list');
    let id_textarea_comment = document.getElementById('textarea_comment');
    let id_btn_comment_add = document.getElementById('btn_comment_add');
    show(hotel_list);
    if (city_id == "") {
        remove(hotel_list);
        remove(id_textarea_comment);
        remove(id_btn_comment_add);
        return;
    }

    /* Создаем AJAX-объект */
    if (window.XMLHttpRequest) {
        ao = new XMLHttpRequest();
    } else {
        ao = new ActiveXObject('Microsoft.XMLHTTP');
    }

    /* Создаем функцию для приема результата запроса */
    ao.onreadystatechange = function () {
        /* Если операция завершена (4) и статус ответа 200, выводим список городов */
        if (ao.readyState == 4 && ao.status == 200) {
            hotel_list.innerHTML = ao.responseText;
        }
    }
    /* Создаем и отправляем AJAX-запрос методом POST */
    ao.open("POST", "pages/ajax_hotel_options.php", true);
    ao.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
    ao.send("cid=" + city_id);
}
function showTextarea(hotel_id) {
    let id_textarea_comment = document.getElementById('textarea_comment');
    let id_btn_comment_add = document.getElementById('btn_comment_add');
    if (hotel_id === '') {
        remove(id_textarea_comment);
        remove(id_btn_comment_add);
        return;
    }
    show(id_textarea_comment);
    show(id_btn_comment_add);
}
