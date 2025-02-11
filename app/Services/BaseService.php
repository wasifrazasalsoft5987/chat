<?php

namespace App\Services;

class BaseService
{
    protected $pagination;

    public function __construct()
    {
        $requestPerPage = config('chat.paginate_records', 25);
        $this->pagination = $requestPerPage;
    }
}