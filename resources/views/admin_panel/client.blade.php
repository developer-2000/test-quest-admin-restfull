<!-- Главная страница клиента -->
@extends('layouts.admin_panel_layout')
@section('content')

    <div class="block_content">

        <!-- Main content -->
        <section class="content">

            <!-- создание компании -->
            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Клиенты</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-info" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            Создать клиента
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="create_name">Имя</label>
                        <input name="create_name" type="text" id="create_name" placeholder="впишите свое имя" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="create_people_id">принадлежность к компании</label>
                        <select name="create_people_id" class="form-control" id="create_people_id">
                        </select>
                    </div>
                    <div class="form-group" id="create_butt">
                        <button type="button" class="btn btn-block btn-success" onclick="createPeople()">Создать</button>
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
                                    <th class="col-md-2">Имя клиента</th>
                                    <th class="col-md-5">Принадлежность к компании</th>
                                    <th class="col-md-3">Действия</th>
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
                            <label for="company">Имя клиента</label>
                            <input type="text" id="title_company" placeholder="Сергей..." class="form-control">
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
        let select_company_id = '';

        // =================
        // смена значений select company
        $("#create_people_id").change(function() {
            select_company_id = $( this ).val();
        });

        // =================
        // подгрузка 20 компаний
        fetch(domen+'api/admin/company/select_for_people', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "Authorization": bearer_token
            },
            method: 'post',
            credentials: "same-origin",
        })
        .then(data => data.json())
        .then( response => {
            let html = '';
            if(response.status == 'success'){
                company = response.message;
                for(let i=0; i<company.length; i++){
                    html += '<option value="'+company[i].id+'">'+company[i].title+'</option>';
                }
            }
            $('#create_people_id').html('').append(html);
        })
        .catch(function (error) {
            console.log(error);
        });


        loadPeople();

         // открыть модалку и вставить данные
        function openModal(value) {

            console.log(value);
            console.log(data);
            // вставка в модалку
            for(let i=0; i<data.length; i++){
                if(data[i].id == value){
                    console.log(data[i].name);
                    $('#title_company').val(data[i].name);
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

            // обновить компанию
            fetch(domen+'api/admin/client/'+company_id, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "Authorization": bearer_token
                },
                method: 'PATCH',
                credentials: "same-origin",
                body: JSON.stringify({
                    'name': title,
                })
            })
            .then(data => data.json())
            .then( response => {
                if (response.errors === undefined) {
                    // закрыть модалку
                    $("#table_title_"+company_id).text(title);
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
        // создать клиента
        function createPeople() {
            fetch(domen+'api/admin/client', {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "Authorization": bearer_token
                },
                method: 'POST',
                credentials: "same-origin",
                body: JSON.stringify({
                    'name': $('#create_name').val(),
                    'company_id': select_company_id
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
        // удалить клиента
        function deleteCompany(value) {
            fetch(domen+'api/admin/client/'+value, {
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
        // подгрузка людей
        function loadPeople($path = domen+'api/admin/client'){
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
                            html += '<tr><td class="col-md-2" id="table_title_'+data[i].id+'">'+data[i].name+'</td>';
                            select = '<option>'+data[i].company.title+'</option>';
                            html += '<td class="col-md-2"><div class="col-sm-12"><select class="form-control">'+select+'</select></div></td>';
                            html += '<td class="col-md-3"><div class="action">';
                            html += '<button type="button" class="btn btn-block btn-primary" onclick="openModal('+data[i].id+')">редактировать</button>';
                            html += '<button type="button" class="btn btn-block btn-warning" onclick="deleteCompany('+data[i].id+')">удалить</button>';
                            html += '</div></td></tr>';
                        }

                        $('#tbody_company').html('').append(html);
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


