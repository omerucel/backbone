<?php

namespace Project\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $surname
 * @property $email
 * @property $password
 * @property $role
 */
class User extends Model
{
    protected $table = 'user';
    public $timestamps = false;

    /**
     * @param $password
     * @return bool
     */
    public function isValidPassword($password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = static::generatePassword($password);
    }

    /**
     * @param $password
     * @return bool|string
     */
    public static function generatePassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}
