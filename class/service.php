<?php



// CREATE TABLE services(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
//     service VARCHAR(255) NOT NULL,
//     price DECIMAL(10,0) NOT NULL,
// 	   duration_value INT NOT NULL,
//     duration_unit ENUM('minute','hour','day','week') DEFAULT 'hour'

// );

class Service extends Db_object
{
    public static $db_name = "services";
    public static $db_fields = array('service', 'price', 'duration_value', 'duration_unit');
    public $id;
    public $service;
    public $price;
    public $duration_value;
    public $duration_unit;
    public static $available_services = [
        [
            'service' => 'Oil and Filter Change',
            'price' => 120,
            'duration_value' => 1,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'Full Engine Diagnostics',
            'price' => 250,
            'duration_value' => 2,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'Brake Pad Replacement',
            'price' => 300,
            'duration_value' => 3,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'Tire Rotation and Balancing',
            'price' => 80,
            'duration_value' => 45, // Note: since your unit is 'minute', you could use 45, or 1 hour
            'duration_unit' => 'minute',
        ],
        [
            'service' => 'Wheel Alignment',
            'price' => 150,
            'duration_value' => 1,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'AC System Recharge and Service',
            'price' => 200,
            'duration_value' => 2,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'Transmission Fluid Flush',
            'price' => 350,
            'duration_value' => 3,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'Spark Plug Replacement',
            'price' => 180,
            'duration_value' => 1,
            'duration_unit' => 'hour',
        ],
        [
            'service' => 'Full Body Detailing and Polishing',
            'price' => 600,
            'duration_value' => 1,
            'duration_unit' => 'day',
        ],
        [
            'service' => 'Engine Overhaul & Repair',
            'price' => 2500,
            'duration_value' => 1,
            'duration_unit' => 'week',
        ],
    ];
    public function create_service()
    {
        foreach (self::$available_services as $ser) {
            if (self::exists_by_name($ser['service'])) {
                continue;
            }
            $service = new self();
            $service->service        = $ser['service'];
            $service->price          = $ser['price'];
            $service->duration_value = $ser['duration_value'];
            $service->duration_unit  = $ser['duration_unit'];
            $service->create();
        }
    }
    public static function exists_by_name($service)
    {
        $sql = "SELECT * FROM " . self::$db_name . " WHERE service=:service LIMIT 1";
        $result = self::find_by_query($sql, [":service" => $service]);
        return !empty($result) ? array_shift($result) : false;
    }
    
}
