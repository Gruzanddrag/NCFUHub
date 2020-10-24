<?php


namespace App\Controller\API\InternshipResponse;


use App\Entity\InternshipResponse;
use App\Entity\JobResponse;

class CreateResponse
{

    public function __construct()
    {
    }

    public function __invoke(InternshipResponse $data): InternshipResponse
    {
        // При новой заявке говорим что она активна
        $data->setStatus(JobResponse::STATUS_ACTIVE);
        $data->setCreatedAt(time());
        return $data;
    }
}