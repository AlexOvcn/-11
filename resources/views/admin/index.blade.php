@extends('master')
@extends('user.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <p class="admin-subtitle">> Элементы управления контентом:</p>
    <div class="flex-block linksBlockFromAdminPanel" style="justify-content: space-evenly">
        <a href="{{route('admin.album')}}" class="btn-admin btn-adminLeft" onclick="darkScreenShow()" style="background-image: url('{{asset('assets/img/albumsLink.JPG')}}')">
            <p>Все неподтвержденные альбомы</p>
        </a>
        <a href="{{route('admin.comment')}}" class="btn-admin btn-adminRight" onclick="darkScreenShow()" style="background-image: url('{{asset('assets/img/commentsLink.JPG')}}">
            <p>Все неподтвержденные комментарии</p>
        </a>
    </div>
    <p class="admin-subtitle">> Элементы управления пользователями:</p>
    <div class="flex-block" style="margin: 30px 0 60px 0; align-items: flex-start">
        <div>
            <p class="titleFromUserControl">Выбор пользователя</p>
            <select class="input" id="selectUser" oninput="showInfoOfUser(this.value)" style="width: auto">
                <option value="0">Выберите пользователя</option>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">Логин: {{$user->name}} / Почта: {{$user->email}}</option>
                @endforeach
            </select>
        </div>
        <div class="userPasport hidden-userInfo" id="userPasport">
            <p class="titleFromUserControl" id="tilte_for_userPasport">Паспорт пользователя</p>
            <div class="userPasportTable">
                <div class="userPasportTable_avatar" style="background-image: url('{{asset('assets/img/hasNotAvatar.jpg')}}')" id="avatar"></div>
                <p class="userPasportTable_text">Логин: <span id="name"></span></p>
                <p class="userPasportTable_text">Email: <span id="email"></span></p>
                <p class="userPasportTable_text" id="status"></p>
                <p class="userPasportTable_text">Роль: <span id="role"></span></p>
                <p class="userPasportTable_text">Дата регистрации: <span id="created_at"></span></p>
            </div>
        </div>
        <div class="actionsWithUser hidden-userInfo" id="actionsWithUser" style="display: flex; flex-direction: column; text-align: center">
            <p class="titleFromUserControl">Действия над пользователем</p>
            <a href="#" id="firstButton"></a>
            <a href="#" id="secondButton"></a>
        </div>
    </div>
    <p class="admin-subtitle">> Элементы управления исполнителями:</p>
    <div>
        <form action="Действие отменено" class="mt-50 flex-block" style="justify-content: flex-start;" id="formDeleteArtist">
            <select name="select" class="input" style="width: auto" id="artistSelectForDelete">
                <option value="">Выберите исполнителя</option>
                @foreach ($artists as $artist)
                    <option value="{{$artist->id}}">{{$artist->artist_name}}</option>
                @endforeach
            </select>
            <button type="submit" name="btn" class="btn cancel-btn ml-30">Удалить</button>
        </form>
        <form action="Действие отменено" class="mt-30 flex-block" style="justify-content: flex-start;" id="formAddArtist">
            <input name ='input' type="text" class="input" style="width: auto" placeholder="Имя исполнителя" id="inputFromFormAddArtist">
            <button type="submit"  name="btn" class="btn confirmation-btn ml-30">Добавить</button>
        </form>
    </div>
@endsection
