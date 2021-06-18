<?php

namespace Tests;


class ValidationTestHelper
{

    public static function basicRequiredInputTest()
    {
        return [
            [null],
            [''],
            [' '],
        ];
    }

    public static function basicEmailInputTest()
    {
        return [
            ['test'],
            ['test@'],
            ['test@test'],
            ['test@test.'],
        ];
    }

    public static function basicDateStringInputTest()
    {
        return [
            ['not a date'],
            ['1325376000'],
            ['2017'],
            ['2017 10 11'],
        ];
    }
}