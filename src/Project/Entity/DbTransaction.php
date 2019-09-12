<?php

namespace Project\Entity;

use Illuminate\Database\Eloquent\Model;

class DbTransaction extends Model
{
    public static function begin()
    {
        self::getConnectionResolver()->connection()->beginTransaction();
    }

    public static function commit()
    {
        self::getConnectionResolver()->connection()->commit();
    }

    public static function rollBack()
    {
        self::getConnectionResolver()->connection()->rollBack();
    }

    /**
     * @param \Closure $closure
     * @param int $attempts
     * @throws \Throwable
     */
    public static function transaction(\Closure $closure, $attempts = 1)
    {
        self::getConnectionResolver()->connection()->transaction($closure, $attempts);
    }
}
