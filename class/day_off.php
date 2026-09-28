<?php




// CREATE TABLE day_off(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//     staff_id INT NOT NULL,
//     date DATE NOT NULL,
//     reason TEXT DEFAULT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE,
// );

class DayOff extends Db_object
{
    public static $db_name = "day_off";
    public static $db_fields = array('staff_id', 'date', 'reason');
    public $id;
    public $staff_id;
    public $date;
    public $reason;
    public static function getDayOffForMember($staff_id)
    {
        $sql = "SELECT * FROM "  . self::$db_name . " WHERE staff_id=:staff_id";
        $res = self::find_by_query($sql, [':staff_id' => $staff_id]);
        return $res ? array_shift($res) : [];
    }
}
