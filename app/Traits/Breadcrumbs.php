<?php

namespace App\Traits;

trait Breadcrumbs
{
    public function get_bread()
    {
        $url = $_SERVER['REQUEST_URI'];
        $urls = explode('/', $url);

        //На главной не показываем
        $return_url_with_desc = [];
        foreach ($urls as $url) {
            if (empty($url)) {
                array_push($return_url_with_desc, ['url' => '/', 'text' => 'Главная страница']);
            }

            //Прописываем название пункта, исходя из url
            switch ($url) {
                case 'hotels':
                    array_push($return_url_with_desc, ['url' => $url, 'text' => 'Отели']);
                    break;
            }
        }

        return $return_url_with_desc;
    }
}
