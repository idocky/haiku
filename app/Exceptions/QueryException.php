<?php

namespace App\Exceptions;


class QueryException extends CustomException
{
    public static function wrongData(string $model)
    {
        return new self($model . ' doesnt exist', 404);
    }


}
