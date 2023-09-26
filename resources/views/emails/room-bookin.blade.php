<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style>  
    /* Base */
    @media only screen and (max-width: 630px) {
        .content {
            width: 100% !important;
        }
    }

    body,
    body *:not(html):not(style):not(br):not(tr):not(code) {
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
        'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        position: relative;
    }

    body {
        -webkit-text-size-adjust: none;
        background-color: #ffffff;
        color: #515561;
        height: 100%;
        line-height: 1.2;
        margin: 0;
        padding: 0;
        width: 100% !important;
        font-size: 16px;
    }

    p,
    ul,
    ol,
    blockquote {
        line-height: 1.4;
        text-align: left;
    }

    a {
        color: #3869d4;
    }

    a img {
        border: none;
    }

    /* Typography */
    img {
        max-width: 100%;
    }
    
    /** Main */
        
    .h2 {
        font-size: 16px;
        font-weight: bold;
        margin-top: 0;
        text-align: left;
    }    

    .logo {        
        max-width: 234px;
        height: auto;
        margin: 15px 0;
    }
</style>

<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" width="100%" style="padding: 10px;">
            <table class="content" width="630px" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="header" width="100%">
                        <a href="{{ config('app.url') }}" style="display: inline-block;">
                            <img src="{{ asset('img/logo.png') }}" alt="GoRooms" class="logo">
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="h2">Бронирование Номер: {{$data->book_number }}</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>                            
                            <tr>
                                <td><strong>Объект размещения: </strong><a href="{{route('hotels.show', ['hotel' => $room->hotel])}}">{{$room->hotel->name}}</a> (ID {{$room->hotel->id}})</td>                                
                            </tr>
                            <tr>
                                <td><strong>Категория: </strong>{{ $room->hotel->type->single_name ?? '-' }}</td>                                
                            </tr>
                            <tr>
                                <td><strong>Номер: </strong>{{ Domain\Room\Actions\GetRoomFullNameAction::run($room) }}</td>                                
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td><strong>Забронировано на: </strong>{{ Domain\Room\Actions\GenerateOrderedOnTextAction::run($data->book_type, $data->hours_count, $data->days_count) }}</td>                                
                            </tr>
                            <tr>
                                <td><strong>Заезд: </strong>{{ $data->from_date->format('d.m.Y H:i') }}</td>                                
                            </tr>
                            <tr>
                                <td><strong>Выезд: </strong>{{ $data->to_date->format('d.m.Y H:i') }}</td>                               
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td><strong>Стоимость проживания: </strong>{{ $data->amount }} р.</td>                               
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td><strong>Имя: </strong>{{ $data->client_fio }}</td>                                
                            </tr>
                            <tr>
                                <td><strong>Телефон: </strong>{{ $data->client_phone }}</td>                               
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td><strong>Комментарий: </strong>{{ $data->book_comment ?? '' }}</td>                               
                            </tr>
                                                     
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="footer" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td style="color: #EF4444;">
                                    <strong>Во избежание репутационных потерь, убедительная просьба незамедлительно связаться с клиентом  подтвердить или отменить бронирование!</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td style="color: rgb(29 78 216); font-size: 14px;">
                                    <strong>Теперь вы можете получать бронирования в Телеграмм!</strong><img src="{{ asset('img/ico-tg.png') }}" alt="tg" style="max-height: 14px; margin: 0 5px;">
                                    <br>
                                    <strong>Если Вам не удобно следить за бронированиями по e-mail, у нас заработал сервис уведомлений в Телеграмм.</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>
                                    <a href="https://youtu.be/5fqTHx45kk8?si=boe7rADh4P17wLVn" target="_blank" style="font-size: 14px; color: #515561; background-color: #eaeffd; border-radius: 14px; padding: 0px 7px;">
                                        <img src="{{ asset('img/ico-yt.png') }}" alt="yt" style="height: 12px; margin-right: 5px;">Телеграм Бот @GoRoomsBot
                                    </a>                                
                                </td>
                            </tr>
                            <tr>
                                <td style="color: rgb(29 78 216); font-size: 14px;">
                                    E-mail используемый для входа в ЛК отельера: {{$room->hotel->user?->email}}                                
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
