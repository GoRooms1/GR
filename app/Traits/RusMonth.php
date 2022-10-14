<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 31.07.2020
 * Time: 15:22
 */

namespace App\Traits;

trait RusMonth
{
    protected $monthNames = [
        1 => [
            'short' => 'янв',
            'full' => 'январь',
        ],
        2 => [
            'short' => 'фев',
            'full' => 'февраль',
        ],
        3 => [
            'short' => 'мар',
            'full' => 'март',
        ],
        4 => [
            'short' => 'апр',
            'full' => 'апрель',
        ],
        5 => [
            'short' => 'май',
            'full' => 'май',
        ],
        6 => [
            'short' => 'июн',
            'full' => 'июнь',
        ],
        7 => [
            'short' => 'июл',
            'full' => 'июль',
        ],
        8 => [
            'short' => 'авг',
            'full' => 'август',
        ],
        9 => [
            'short' => 'сен',
            'full' => 'сентябрь',
        ],
        10 => [
            'short' => 'окт',
            'full' => 'октябрь',
        ],
        11 => [
            'short' => 'ноя',
            'full' => 'ноябрь',
        ],
        12 => [
            'short' => 'дек',
            'full' => 'декабрь',
        ],
    ];

    public function getCreateMonthName(bool $full = false): string
    {
        $month = (int) $this->created_at->format('m');

        return $this->getMonthName($month, $full);
    }

    public function getMonthName(int $month, bool $full = false): string
    {
        if ($month < 1 || $month > 12) {
            return '';
        }

        return $this->monthNames[$month][$full ? 'full' : 'short'];
    }
}
