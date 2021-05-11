<?php
namespace App\Services;

use App\Models\Company;

class CompanyServices {

    // Создание компании
    // ========================================
    public function store($index){
        $company = Company::create($index);

        return $company;
    }

    // Обновление компании
    // ========================================
    public function update($index){
        $company = Company::where('id', $index['id'])
            ->update([
                'title' => $index['title'],
                'description' => $index['description'],
            ]);

        return $company ? true : false;
    }

    // Выбрать компании в пагинации
    // ========================================
    public function index(){
        $step = config('admin_panel.setings.pagination');
        $pagination = Company::with('clients')
            ->orderBy('id', 'desc')
            ->paginate($step);

        return $pagination;
    }

}
