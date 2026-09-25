<?php


// !
// CREATE TABLE booking_service(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//     user_id INT NOT NULL,
//     staff_id INT NOT NULL,
//     service_id INT NOT NULL,
//     description TEXT DEFAULT NULL,
//     booking_date DATE NOT NULL,
//     start_time TIME NOT NULL,
//     end_time TIME NOT NULL,
//      status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending',
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     completed_at DATETIME DEFAULT NULL,
//     FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
//     FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE CASCADE,
//     FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
// );





class BookingService extends Db_object
{
    public static $db_name = "booking_service";
    public static $db_fields = array(
        'user_id',
        'staff_id',
        'service_id',
        'description',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'completed_at'
    );
    public $id;
    public $user_id;
    public $staff_id;
    public $service_id;
    public $progress;
    public $description;
    public $booking_date;
    public $start_time;
    public $end_time;
    public $status;

    public $completed_at;
}
