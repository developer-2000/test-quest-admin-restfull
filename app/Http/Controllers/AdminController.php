<?php
namespace App\Http\Controllers;

use App\Services\CompanyServices;

class AdminController extends BaseApiController {

    protected $adminService;

    public function __construct() {
        parent::__construct();
        $this->adminService = new CompanyServices();
    }

    // ===================================
    // проверка доступа по bearer token
    public function access() {
        return $this->getSuccessResponse(200);
    }

    // ===================================
    // стартовая страница админки
    public function adminPanel() {
        return view('admin_panel.admin_panel');
    }

    // ===================================
    // загрузка авторизации
    public function adminAuth() {
        return view('admin_panel.authorization');
    }

    // ===================================
    // страница компаний
    public function company() {
        return view('admin_panel.company');
    }

    // ===================================
    // страница клиентов
    public function client() {
        return view('admin_panel.client');
    }


}
