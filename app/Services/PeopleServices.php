<?php
namespace App\Services;

use App\Models\Company;
use App\Models\People;

class PeopleServices {

    // Создание клиента
    // ========================================
    public function store($index){
        $people = People::create($index);

        return $people ? true : false;
    }

    // Обновление компании
    // ========================================
    public function update($index){
        $company = People::where('id', $index['people_id'])
            ->update([
                'name' => $index['name'],
            ]);

        return $company ? true : false;
    }

    // Выбрать людей в пагинации
    // ========================================
    public function index(){
        $step = config('admin_panel.pagination');
        $pagination = People::with('company')
            ->orderBy('id', 'desc')
            ->paginate($step);

        return $pagination;
    }

}
