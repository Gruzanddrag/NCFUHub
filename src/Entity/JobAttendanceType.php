<?php


namespace App\Entity;


class JobAttendanceType
{
    /**
     * @var string
     */
    private $typeName;

    /**
     * JobResponseStatus constructor.
     * @param $type
     */
    public function __construct($type)
    {
        switch ($type) {
            case (Job::JOB_EMPLOYMENT_TYPE_FULL_TIME):
                $this->typeName = 'Полная ставка';
                break;
            case (Job::JOB_EMPLOYMENT_TYPE_PART_TIME):
                $this->typeName = 'Не полная ставка';
                break;
        }
    }

    public function __toString()
    {
        return $this->typeName;
    }
}