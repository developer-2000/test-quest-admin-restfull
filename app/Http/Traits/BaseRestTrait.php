<?php
namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Trait BaseRestTrait
 * @package App\Traits
 */
trait BaseRestTrait
{
    /**
     * Get the JSON response.
     *
     * @param mixed    $data
     * @param int $httpStatus
     *
     * @return JsonResponse
     */
    public function getResponse($data, $httpStatus = 200): JsonResponse {
        return Response::json([ 'status'=>'success', 'message'=>$data ], $httpStatus);
    }

    /**
     * @param $message
     * @param int $httpStatus
     * @param array $errors
     * @return array
     */
    public function getErrorResponse($message, $httpStatus = 400, $errors = []) {
        return $this->answerGenerate($message, $errors);
    }

    /**
     * @param $message
     * @param int $httpStatus
     * @param array $errors
     * @return JsonResponse
     */
    public function getModelAlreadyExists($message, $httpStatus = 409, array $errors = []): JsonResponse
    {
        return $this->getResponse($this->answerGenerate($message, $errors), $httpStatus);
    }

    /**
     * @param $message
     * @param int $httpStatus
     * @param array $errors
     * @return JsonResponse
     */
    public function getModelNotFound($message, $httpStatus = 404, array $errors = []): JsonResponse
    {
        return $this->getResponse($this->answerGenerate($message, $errors), $httpStatus);
    }

    /**
     * @param int $httpStatus = 204
     * @return JsonResponse
     */
    public function getSuccessResponse($httpStatus = 204): JsonResponse
    {
        return $this->getResponse(['message' => 'success'], $httpStatus);
    }

    /**
     * Generate  answer for unist
     * @param $message
     * @param $errors
     * @return array
     */
    public function answerGenerate($message, $errors){
        if(empty($errors)){
            $errors = ['error' => [$message]];
        }
        return [
            "status" => 'error',
            "message" => $message,
            "errors"  => $errors
        ];
    }

    /**
     * @param $id
     * @param $tableName
     */
    public function validationID($id, $tableName){
        $valid = 'exists:' . $tableName . ',id';
        Validator::make(['id' => $id], [
            'id' => ['integer', $valid]
        ])->validate();
    }
}
