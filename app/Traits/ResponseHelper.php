<?php

namespace App\Traits;

trait ResponseHelper
{
    protected $statusCode;
    protected $response = [];
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function respond()
    {
        return response()->json($this->response, $this->getStatusCode() ?? 200);
    }

    public function buildResponse($success, $message, $data = null)
    {
        $this->response = ["message" => $message, "success" => $success, "data" => $data];
        return $this;
    }


    public function respondUnauthorized($message = 'Unauthorized action.')
    {
        return $this->setStatusCode(403)
            ->respondWithError($message);
    }

    public function respondNotFound($data = null, $additional_data = [])
    {
        return $this->setStatusCode(404)->buildResponse(false, "Data Not Found", $data)->respond();
    }

    public function respondCreated($data = null, $message = "Added Sucessfully.")
    {
        return $this->setStatusCode(201)->buildResponse(true, $message, $data)->respond();
    }

    public function respondBadRequest($message = "Bad request")
    {
        return $this->setStatusCode(400)->buildResponse(false, $message)->respond();
    }
    public function respondSuccess($data, $additional_data = [])
    {
        return $this->buildResponse(true, "Data Found Successfully", $data)->respond();
    }
}
