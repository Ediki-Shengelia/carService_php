<?php




// CREATE TABLE day_off(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//     staff_id INT NOT NULL,
//     bk_id INT NOT NULL,
//     date DATE NOT NULL,
//     reason TEXT DEFAULT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE,
//     FOREIGN KEY (bk_id) REFERENCES booking_service(id) ON DELETE CASCADE
// );

class DayOff extends Db_object
{
    public static $db_name = "day_off";
    public static $db_fields = array('staff_id', 'bk_id', 'date', 'reason');
    public $id;
    public $staff_id;
    public $bk_id;
    public $date;
    public $reason;
}
