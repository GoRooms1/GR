<div class="form-group">
    <label for="name">Имя</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? @$user->name ?? '' }}"
           class="form-control " required/>
</div>
<div class="form-group">
    <label for="name">E-mail</label>
    <input type="email" name="email" id="email" value="{{ old('email') ?? @$user->email ?? '' }}"
           class="form-control " required/>
</div>
<div class="form-group">
    <label for="name">Телефон</label>
    <input type="text" name="phone" id="phone" value="{{ old('phone') ?? @$user->phone ?? '' }}"
           class="form-control " required/>
</div>
<div class="form-group">
    <label for="name">Пароль</label>
    <input type="password" name="password" id="password"
           class="form-control" {{ Route::currentRouteNamed('admin.moderators.create') ? 'required' : '' }}/>
</div>