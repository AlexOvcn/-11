


function admin_selectUser_ajax(user_email) {

    let showRolesOptions_deleteOne = document.querySelector('#selectRole_deleteOneRole');
    let showRolesOptions_addOne = document.querySelector('#selectRole_addOneRole');
    let showRolesBlock = document.querySelector('#showRoles');

    if (user_email === '0') {
        showRolesBlock.innerHTML = '<p>Пользователь не выбран</p>';
        showRolesOptions_deleteOne.innerHTML = '<option value="0" selected>Выберите роль</option>';
        showRolesOptions_addOne.innerHTML = '<option value="0" selected>Выберите роль</option>';
        return;
    } else {
        showRolesBlock.innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    }

    let inputEmailForSelectRoleDelete = document.querySelector('#emailForSelectDelete');
    inputEmailForSelectRoleDelete.setAttribute('value', `${user_email}`);
    let inputEmailForSelectRoleAdd = document.querySelector('#emailForSelectAdd');
    inputEmailForSelectRoleAdd.setAttribute('value', `${user_email}`);

    let csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let params = new FormData();
    params.set('_token', csrf_token);
    params.set('email', user_email);

    // for (key of params.keys()) {
    //     console.log(`${key}: ${params.get(key)}`);
    // } // позволяет посмотреть все ключи обьекта FormData

    // все роли пользователя
    fetch('http://127.0.0.1:8000/admin/ajax-getRoles', {
        method: 'POST',
        mode: 'no-cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {'Content-Type': 'application/json'},
        body: params
    })
    .then((promise) => {
        promise.json().then(response => {

            showRolesBlock.innerHTML = '';
            if (response.roles.length === 0) {
                showRolesBlock.innerHTML = '<p>Роли отсутствуют</p>';
            }
            for (let i = 0; i < response.roles.length; i++) {

                let newElem = document.createElement('li');
                newElem.setAttribute('type', 'circle');
                newElem.innerHTML = `${response.roles[i].role}`;
                showRolesBlock.append(newElem);
            }
        })
    });

    // все роли пользователя (используя в контроллере "whereHas/where")
    fetch('http://127.0.0.1:8000/admin/ajax-getRolesForActionDeleteOneRole', {
        method: 'POST',
        mode: 'no-cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {'Content-Type': 'application/json'},
        body: params
    }).then(promise => {
        promise.json().then(response => {

            showRolesOptions_deleteOne.innerHTML = '<option value="0" selected>Выберите роль</option>';

            for (let i = 0; i < response.roles.length; i++) {

                let role = response.roles[i];
                let newElem = document.createElement('option');
                newElem.innerHTML = `${role.role}`;
                showRolesOptions_deleteOne.append(newElem);
            }
        })
    })

    // все роли пользователя (используя в контроллере "whereDoesntHave/where")
    fetch('http://127.0.0.1:8000/admin/ajax-getRolesForActionAddOneRole', {
        method: 'POST',
        mode: 'no-cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {'Content-Type': 'application/json'},
        body: params
    }).then(promise => {
        promise.json().then(response => {

            showRolesOptions_addOne.innerHTML = '<option value="0" selected>Выберите роль</option>';

            for (let i = 0; i < response.roles.length; i++) {

                let role = response.roles[i];
                let newElem = document.createElement('option');
                newElem.innerHTML = `${role.role}`;
                showRolesOptions_addOne.append(newElem);
            }
        })
    })
}


document.addEventListener('DOMContentLoaded', function(){

    let selectUser = document.querySelector('#selectUser');

    if (selectUser !== null) {
        admin_selectUser_ajax(selectUser.value);
    }

});

