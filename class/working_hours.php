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
    public $working_hours = [
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
        [
            'day_of_week' => 'Saturday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ],
        [
            'day_of_week' => 'Sunday',
            'start_time'  => '09:00:00',
            'end_time'    => '18:00:00'
        ]
    ];
}
