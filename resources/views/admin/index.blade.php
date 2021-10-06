@extends('master')
@extends('header.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <div class="flex-block" style="align-items: flex-start; margin-top: 100px">
        <div>
            <h3 class="admin-title">Выбор пользователя</h3>
            <select class="admin-select" name="selectUser" id="selectUser" oninput="admin_selectUser_ajax(this.value)">
                <option value="0">Выберите пользователя</option>
                @foreach ($users as $user)
                    <option value="{{$user->email}}" {{old('email') === $user->email ? 'selected' : null}} >Логин: {{$user->name}} / Почта: {{$user->email}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <h3 class="admin-title">Все роли пользователя</h3>
            <div id="showRoles" class="admin-allRolesShow"><p>Загрузка..</p></div>
        </div>
        <div class="admin-blockWithSelectElements">
            <h3 class="admin-title">Действия с ролями</h3>
            <form class="admin-formSelect_flex" action="{{route('admin.ajax-attachOneRole')}}" method="post">
                @csrf
                <input type="hidden" name="email" id="emailForSelectAdd">
                <select class="admin-select" id="selectRole_addOneRole" name="role">
                    <option value="0" selected>Выберите роль</option>
                </select>
                <button class="button-edit" style="padding: 8.6px 0; width: 135px">Добавить</button>
            </form>
            <form class="admin-formSelect_flex" action="{{route('admin.ajax-detachOneRole')}}" method="post">
                @csrf   @method('delete')
                <input type="hidden" name="email" id="emailForSelectDelete">
                <select class="admin-select" id="selectRole_deleteOneRole" name="role">
                    <option value="0" selected>Выберите роль</option>
                </select>
                <button class="button-delete" style="padding: 8.6px 0; width: 135px">Удалить</button>
            </form>
        </div>
    </div>
@endsection
