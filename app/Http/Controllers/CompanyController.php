<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\DestroyCompanyRequest;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyServices;

class CompanyController extends BaseApiController {

    protected $companyService;

    public function __construct() {
        parent::__construct();
        $this->companyService = new CompanyServices();
    }

    /**
     * Создание компании
     * @param StoreCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCompanyRequest $request) {
        $index = $request->validated();
        $company = $this->companyService->store($index);

        return $this->getResponse($company, 201);
    }

    /**
     * Обновление компании
     * @param UpdateCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCompanyRequest $request) {
        $index = $request->validated();
        $company = $this->companyService->update($index);

        return $this->getResponse($company, 201);
    }

    /**
     * Удаление компании
     * @param DestroyCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyCompanyRequest $request) {
        $index = $request->validated();
        $bool = Company::where('id', $index['id'])
            ->delete();

        return $this->getResponse($bool ? true : false, 201);
    }

    /**
     * Выбрать компании в пагинации
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $pagination = $this->companyService->index();

        return $this->getResponse($pagination, 201);
    }

    // выборка 20 компаний для создания клиента в админке
    public function selectTwenty() {
        $companies = Company::limit(20)->get();;

        return $this->getResponse($companies, 201);
    }
}
