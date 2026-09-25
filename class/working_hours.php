<?php


// CREATE TABLE working_hours(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//      day_of_week ENUM('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
//     start_time TIME NOT NULL,
//     end_time TIME NOT NULL
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );



class WorkingHours extends Db_object
{
    public static $db_name = "working_hours";
    public static $db_fields = array('day_of_week', 'start_time', 'end_time');
    public $id;
    public $day_of_week;
    public $start_time;
    public $end_time;
    public static $working_hours = [
        [
            'day_of_week' => 'Monday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ],
        [
            'day_of_week' => 'Tuesday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ],
        [
            'day_of_week' => 'Wednesday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ],
        [
            'day_of_week' => 'Thursday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ],
        [
            'day_of_week' => 'Friday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ],
       
    ];
    public static function working_hours_exists($day_of_week, $start_time, $end_time)
    {
        $sql = "SELECT * FROM " . self::$db_name . " WHERE day_of_week = :day_of_week AND start_time=:start_time AND end_time=:end_time LIMIT 1";
        $result = self::find_by_query($sql, [
            ":day_of_week" => $day_of_week,
            ":start_time" => $start_time,
            ":end_time" => $end_time
        ]);
        return !empty($result) ? array_shift($result) : false;
    }
    public function create_working_hours()
    {
        foreach (self::$working_hours as $wk) {
            if (self::working_hours_exists($wk['day_of_week'], $wk['start_time'], $wk['end_time'])) {
                continue;
            }
            $working_hours = new self;
            $working_hours->day_of_week = $wk['day_of_week'];
            $working_hours->start_time = $wk['start_time'];
            $working_hours->end_time = $wk['end_time'];
            $working_hours->create();
        }
    }
}
