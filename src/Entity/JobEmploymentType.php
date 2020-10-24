<?php


namespace App\Entity;


class JobEmploymentType
{
    /**
     * @var string
     */
    private $typeName;

    /**
     * JobResponseStatus constructor.
     * @param $status
     */
    public function __construct($type)
    {
        switch ($type) {
            case (Job::JOB_ATTENDANCE_OFFICE):
                $this->typeName = 'Очно';
                break;
            case (Job::JOB_ATTENDANCE_REMOTE):
                $this->typeName = 'Заочно';
                break;
        }
    }

    public function __toString()
    {
        return $this->typeName;
    }
}