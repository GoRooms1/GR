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
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Статус: </strong>
                                    <span
                                        @switch($data->status['key'])
                                            @case('wait')
                                            style="color: rgb(107 114 128);"
                                            @break                      
                                            @case('in')
                                            style="color: rgb(37 99 235);"
                                            @break
                                            @case('out')
                                            style="color: rgb(34 197 94);"
                                            @break
                                            @case('cc')
                                            style="color: rgb(249 115 22);"
                                            @break
                                            @case('ch')
                                            style="color: rgb(239 68 68);"
                                            @break                            
                                        @endswitch
                                    >
                                        {{ $data->status['value'] ?? '' }}
                                    </span>
                                </td>                               
                            </tr>
                                                     
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="footer" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>
                                    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>                            
                            <tr>
                                <td style="color: rgb(29 78 216); font-size: 14px;">
                                    E-mail используемый для входа в ЛК отельера: {{implode(', ', $room->hotel->users->pluck('email')->toArray())}}                                
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
