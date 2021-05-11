<?php

namespace App\Http\Controllers;

use App\Http\Requests\People\DestroyPeopleRequest;
use App\Http\Requests\People\StorePeopleRequest;
use App\Http\Requests\People\UpdatePeopleRequest;
use App\Models\People;
use App\Services\PeopleServices;
use Illuminate\Http\Request;

class PeopleController extends BaseApiController {

    protected $peopleService;

    public function __construct() {
    parent::__construct();
    $this->peopleService = new PeopleServices();
}

    /**
     * Создание клиента
     * @param StorePeopleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePeopleRequest $request) {
    $index = $request->validated();
    $people = $this->peopleService->store($index);

    return $this->getResponse($people, 201);
}

    /**
     * Обновление клиента
     * @param UpdatePeopleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePeopleRequest $request) {
    $index = $request->validated();
    $company = $this->peopleService->update($index);

    return $this->getResponse($company, 201);
}

    /**
     * Удаление клиента
     * @param DestroyPeopleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyPeopleRequest $request) {
    $index = $request->validated();
    $bool = People::where('id', $index['id']) ->delete();

    return $this->getResponse($bool ? true : false, 201);
}

    /**
     * Выбрать людей в пагинации
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
    $pagination = $this->peopleService->index();

    return $this->getResponse($pagination, 201);
}
}
