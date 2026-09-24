<?php


class BookingService extends Db_object
{
    public static $db_name = "booking_service";
    public static $db_fields = array('staff_id', 'service_id', 'description', 'created_at', 'completed_at');
    public $id;
    public $staff_id;
    public $service_id;
    public $description;
    public $created_at;
    public $completed_at;
}
