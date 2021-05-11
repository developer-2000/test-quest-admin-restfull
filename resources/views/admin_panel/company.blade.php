<!-- Главная страница клиента -->
@extends('layouts.admin_panel_layout')
    @section('content')

            <div class="block_content">

                <!-- Main content -->
                <section class="content">

                    <!-- создание компании -->
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Компании</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-block btn-info" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    Создать компанию
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="company">Название компании</label>
                                <input type="text" id="create_title" placeholder="e.g. Google" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="desc_company">Описание компании</label>
                                <textarea rows="3" id="create_desc" placeholder="The best" class="form-control desc_pole"></textarea>
                            </div>
                            <div class="form-group" id="create_butt">
                                <button type="button" class="btn btn-block btn-success" onclick="createCompany()">Создать</button>
                            </div>
                        </div>
                        <!-- /.card-body data-damage-resistance="40" -->
                    </div>
                    <!-- /.card -->


                    <!-- Table Company -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover" id="table_company">
                                        <thead>
                                        <tr>
                                            <th class="col-md-3">название</th>
                                            <th class="col-md-3">описание</th>
                                            <th class="col-md-3">клиенты компании</th>
                                            <th class="col-md-3">действия</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody_company"></tbody>
                                    </table>
                                </div>

                                <!-- paginate -->
                                <div class="card-footer clearfix">
                                    <ul class="pagination float-right" id="ul_pagin"></ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Table -->


                </section>
                <!-- /.content -->

                {{-- modal window--}}
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            {{-- body --}}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="company">Название компании</label>
                                    <input type="text" id="title_company" placeholder="e.g. Google" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="desc_company">Описание компании</label>
                                    <textarea rows="3" id="desc_company" placeholder="The best" class="form-control desc_pole"></textarea>
                                </div>
                            </div>

                            {{-- footer --}}
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-primary" data-id="10" id="modal_save" onclick="modalSave()">Save changes</button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

            </div>

    @endsection

@section('scripts')
    @parent
    <script>

        let domen = 'http://test-quest.lara/';
        let bearer_token = localStorage['bearer_token'];
        let data = '';
        loadCompanies();

        {{-- открыть модалку и вставить данные --}}
        function openModal(value) {
            // вставка в модалку
            for(let i=0; i<data.length; i++){
                if(data[i].id == value){
                    $('#title_company').val(data[i].title);
                    $('#desc_company').val(data[i].description);
                    $('#modal_save').attr('data-id', value);
                    break;
                }
            }
            // открыть модалку
            $('#modal-default').modal('toggle');
        }

        {{-- сохранить данные из модалки --}}
        function modalSave() {
            let company_id = $('#modal_save').attr('data-id');
            let title = $('#title_company').val();
            let description = $('#desc_company').val();

            // обновить компанию
            fetch(domen+'api/admin/company/'+company_id, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "Authorization": bearer_token
                },
                method: 'PATCH',
                credentials: "same-origin",
                body: JSON.stringify({
                    'title': title,
                    'description': description
                })
            })
            .then(data => data.json())
            .then( response => {
                if (response.errors === undefined) {
                    // закрыть модалку
                    $("#table_title_"+company_id).text(title);
                    $("#table_desc_"+company_id).text(description);
                    $('#modal-default').modal('toggle');
                }
                else {
                    console.log(response.errors);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        // =================
        // создать компанию
        function createCompany() {

            fetch(domen+'api/admin/company', {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "Authorization": bearer_token
                },
                method: 'POST',
                credentials: "same-origin",
                body: JSON.stringify({
                    'title': $('#create_title').val(),
                    'description': $('#create_desc').val()
                })
            })
                .then(data => data.json())
                .then( response => {
                    if (response.errors === undefined) {
                        window.location.reload();
                    }
                    else {
                        console.log(response.errors);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // =================
        // удалить компанию
        function deleteCompany(value) {
            fetch(domen+'api/admin/company/'+value, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "Authorization": bearer_token
                },
                method: 'delete',
                credentials: "same-origin",
            })
                .then(data => data.json())
                .then( response => {
                    if (response.errors === undefined) {
                        window.location.reload();
                    }
                    else {
                        console.log(response.errors);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // =================
        // подгрузка компаний
        function loadCompanies($path = domen+'api/admin/company'){
            fetch($path, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "Authorization": bearer_token
                },
                method: 'get',
                credentials: "same-origin",
            })
                .then(data => data.json())
                .then( response => {
                    if (response.errors === undefined) {
                        data = response.message.data;
                        let html = '';
                        let select = '';

                        for(let i=0; i<data.length; i++){
                            select = '';
                            html += '<tr><td class="col-md-2" id="table_title_'+data[i].id+'">'+data[i].title+'</td>';
                            html += '<td class="col-md-5" id="table_desc_'+data[i].id+'">'+data[i].description+'</td>';
                            for(let b=0; b<data[i].clients.length; b++){
                                select += '<option>'+data[i].clients[b].name+'</option>';
                            }
                            html += '<td class="col-md-2"><div class="col-sm-12"><select class="form-control">'+select+'</select></div></td>';
                            html += '<td class="col-md-3"><div class="action">';
                            html += '<button type="button" class="btn btn-block btn-primary" onclick="openModal('+data[i].id+')">редактировать</button>';
                            html += '<button type="button" class="btn btn-block btn-warning" onclick="deleteCompany('+data[i].id+')">удалить</button>';
                            html += '</div></td></tr>';
                        }

                        $('#tbody_company').html('').append(html);
                        console.log(response.message);
                        paginateHtml(response.message);
                    }
                    else {
                        console.log(response.errors);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // =================
        // построение пагинации html
        function paginateHtml(pagin){

            if(!pagin.data.length){
                return false;
            }
            let prev_url = pagin.prev_page_url !== null ? pagin.prev_page_url : '#';
            let next_url = pagin.next_page_url !== null ? pagin.next_page_url : '#';
            let prev_page_num = (pagin.prev_page_url !== null) ? parseInt(pagin.prev_page_url.split('=')[1]) : null;
            let to_page_num = parseInt(pagin.current_page);
            let next_page_num = (pagin.next_page_url !== null) ? parseInt(pagin.next_page_url.split('=')[1]) : null;

            let html = '<ul class="pagination float-right">';
            if(prev_url == '#'){
                html += '<li class="page-item"><div class="page-link pagination_button_noactive">&laquo;</div></li>';
            }
            else{
                html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + prev_url + '\')">&laquo;</a></li>';
            }


                // следущая есть
                if(next_page_num !== null){
                    // предыдущий есть
                    if(prev_page_num !== null){
                        html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + prev_url + '\')">'+prev_page_num+'</a></li>';
                        html += '<li class="page-item"><div class="page-link pagination_button_noactive">'+to_page_num+'</div></li>';
                        html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + next_url + '\')">'+next_page_num+'</a></li>';
                    }
                    // предыдущего нет
                    else if(prev_page_num === null){
                        // есть через одного
                        if( ( parseInt(pagin.total) - (next_page_num + 1) ) >= 0){
                            html += '<li class="page-item"><div class="page-link pagination_button_noactive">'+to_page_num+'</div></li>';
                            html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + next_url + '\')">'+next_page_num+'</a></li>';
                            html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + (pagin.path+'?page='+(next_page_num+1)) + '\')">'+(next_page_num+1)+'</a></li>';
                        }
                        // нет через одного
                        else if( ( parseInt(pagin.total) - (next_page_num + 1) ) < 0){
                            html += '<li class="page-item"><div class="page-link pagination_button_noactive">'+to_page_num+'</div></li>';
                            html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + next_url + '\')">'+next_page_num+'</a></li>';
                        }
                    }
                }
                // следущей нет
                else if(next_page_num === null){
                    // у предыдущей есть предшественник - выставить с предшественник
                    if((prev_page_num - 1) > 0){
                        html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + (pagin.path+'?page='+(prev_page_num-1)) + '\')">'+(prev_page_num - 1)+'</a></li>';
                        html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + prev_url + '\')">'+prev_page_num+'</a></li>';
                        html += '<li class="page-item"><div class="page-link pagination_button_noactive">'+to_page_num+'</div></li>';
                    }
                    // у предыдущей нет предшественника - выставить с предыдущей
                    else if(((prev_page_num - 1) == 0) && prev_page_num !== null){
                        html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + prev_url + '\')">'+prev_page_num+'</a></li>';
                        html += '<li class="page-item"><div class="page-link pagination_button_noactive">'+to_page_num+'</div></li>';
                    }
                    // предыдущего нет - выставить с текущий
                    else if(prev_page_num == null){
                        html += '<li class="page-item"><div class="page-link pagination_button_noactive">'+to_page_num+'</div></li>';
                    }
                }

            if(next_url == '#'){
                html += '<li class="page-item"><div class="page-link pagination_button_noactive" >&raquo;</div></li>';
            }
            else{
                html += '<li class="page-item"><a class="page-link" href="#" onclick="loadCompanies(\'' + next_url + '\')">&raquo;</a></li>';
            }

            html += '</ul>';

            $('#ul_pagin').html('').append(html);
        }

    </script>
@endsection

@section('style')
    @parent
    <style>
        .card-tools button{
            min-width: 170px;
        }
        .card{
            margin-bottom: 0px !important;
        }
        .col-12{
            padding-right: 8px !important;
        }
        .row{
            margin-right: -7px; !important;
        }
        .action{
            display: flex;
            justify-content: center;
        }
        .action button{
            min-width: 140px;
            margin-right: 10px;
        }
        .modal-body {
            padding: 20px;
        }
        #create_butt {
            display: flex;
            justify-content: flex-end;
        }
        #create_butt button {
            max-width: 129px;
        }
        .pagination_button_noactive {
            color: #000;
            background-color: #e9ecef;
            cursor: default;
        }
    </style>
@endsection


