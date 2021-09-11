function getItemsCategory(category)
{
    // Если категория не выбрана, очищаем вывод результатов
    if (category == "") {
        document.getElementById('result').innerHTML="";
    }
    // Создание AJAX-объекта
    if (window.XMLHttpRequest)
        ao = new XMLHttpRequest();
    else
        ao = new ActiveXObject('Microsoft.XMLHTTP');

    // Заполнение контейнера результатом выборки
    ao.onreadystatechange = function() {
        if (ao.readyState == 4 && ao.status == 200)
        {
            document.getElementById('result').innerHTML = ao.responseText;
        }
    }

    // Подготовка AJAX-запроса
    ao.open('post','pages/lists.php',true);
    ao.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ao.send("category="+category);
}

// Создаем cookie
function createCookie(username,id)
{
    let date = new Date(new Date().getTime() + 60 * 1000 * 30);
    document.cookie = username+"="+id+"; path=/; expires=" + date.toUTCString();
}

// Удаляем cookie
function eraseCookie(username, id = 0, r_user = null)
{
    let theCookies = document.cookie.split(';');
    for (let i = 0 ; i < theCookies.length; i++)
    {
        if((theCookies[i].split('_').shift()).trim() === username  || (theCookies[i].split('=').shift()).trim() === username) // разделяем каждый элемент куки на два элемента, помещая в массив, разделитель символ '_' после чего вырезаем первый эл массива, у первого эл массива появляются пробелы сначала строки это поправляет метод строки - trim(), второе условие через или описано подобным образом но ловит момент когда username поступает с полным значением логина и индекса товара через символ '_', что означает определенный товар
        {
            if (username === 'cart' || username === r_user) {
                theCookie = theCookies[i].split('=');
            } else {
                theCookie = theCookies[i].split(null);
            }
            let date = new Date(new Date().getTime() - 60 * 1000 * 30);
            document.cookie = theCookie[0] + "="+ id +"; path=/; expires=" + date.toUTCString();
        }
    }
}

// этот ajax элемент выполняет запись рейтинга в БД указанного пользователем
function setRating(item_id, user_id, rating_value)
{
    // Создание AJAX-объекта
    if (window.XMLHttpRequest)
        ao = new XMLHttpRequest();
    else
        ao = new ActiveXObject('Microsoft.XMLHTTP');

    let responseOutput = document.getElementById('resultRatingAnswer');

    // Заполнение контейнера результатом выборки
    ao.onreadystatechange = function() {
        if (ao.readyState == 4 && ao.status == 200)
        {
            if (ao.responseText === 'Ваша оценка учтена') {
                responseOutput.innerHTML = ao.responseText;
                responseOutput.setAttribute('style', 'color:rgb(0, 128, 128)');
            } else {
                responseOutput.innerHTML = ao.responseText;
                responseOutput.setAttribute('style', 'color:rgb(205, 90, 40)');
            }
        }
    }

    // Подготовка AJAX-запроса
    ao.open('post','../pages/ajax-rating.php',true);
    ao.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ao.send("item_id="+item_id+"&user_id="+user_id+"&rating_value="+rating_value);
}

function showRating(rating)
{
    let showingRating;
    switch (rating) {
        case 1:
            showingRating = document.getElementById('HR1');
            break;
        case 2:
            showingRating = document.getElementById('HR2');
            break;
        case 3:
            showingRating = document.getElementById('HR3');
            break;
        case 4:
            showingRating = document.getElementById('HR4');
            break;
        case 5:
            showingRating = document.getElementById('HR5');
            break;
        default:
            return;
    }
    showingRating.classList.add('glow');
}