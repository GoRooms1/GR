<div class="dropdown-divider my-3"></div>
<div class="h2">Отправка сообщений</div>
<p>Перед отправкой сохраните запись!</p>
<form class="row py-1" action="{{ route('admin.bot_message_templates.send-test', $botMessageTemplate) }}" method="POST" enctype="multipart/form-data">
    @csrf           
    <div class="col-8 row">
        <div class="form-group col-6">        
            <input type="text" name="hotel_id" id="hotel_id" class="form-control @error('hotel_id') is-invalid @enderror" placeholder="ID тестового отеля"/>
            @error('hotel_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror           
        </div>
        <div class="col-6">
            <button type="submit" class="btn btn-primary w-100">Отправить на тестовый отель</button>
        </div>
        
    </div>
</form>
<form class="row py-1" action="{{ route('admin.bot_message_templates.send-onetime', $botMessageTemplate) }}" method="POST" enctype="multipart/form-data">
    @csrf           
    <div class="col-8 row">
        <div class="col-6"></div>
        <div class="col-6">
            <button type="submit" class="btn btn-primary w-100">Отправить разовое сообщение</button>
        </div>
    </div>
</form>
<div class="row py-3">
    <div class="col-4">
        Кол-во отправлений пользователям:
    </div>
    <div class="col-4">
        {{ $botMessageTemplate->users_count }}
    </div>
</div>
<div class="row pb-3">
    <div class="col-4">
        Кол-во отправлений отелям:
    </div>
    <div class="col-4">
        {{ $botMessageTemplate->hotels_count }}
    </div>
</div>