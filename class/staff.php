<?php

require_once __DIR__ . '/trait/fileUpload.php';

class Staff extends Db_object
{
    use FileUpload;
    protected function upload_directory(): string
    {
        return "users";
    }
    public static $db_name = "staff";
    public static $db_fields = array(
        'user_id',
        'phone',
        'specialization',
        'role',
        'salary',
        'hire_date'
    );
    public $id;
    public $user_id;
    public $phone;
    public $specialization;
    public $role;
    public $salary;
    public $hire_date;
    public static function find_staff_by_user_id($user_id)
    {
        $sql = "SELECT * FROM " . self::$db_name . " WHERE user_id=:user_id LIMIT 1";
        $result = self::find_by_query($sql, [':user_id' => (int) $user_id]);
        return !empty($result) ? array_shift($result) : false;
    }
}
