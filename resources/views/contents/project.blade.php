@extends('layout.main')

@section('title', 'Project')

@section('css')
    {{-- Custom CSS --}}
@endsection

@section('breadcumb')
<!-- PAGE-HEADER Breadcrumbs -->
<div class="breadcrumb-header justify-content-between">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a   href="javascript:void(0);"></a></li>
                <li class="breadcrumb-item active" aria-current="page"> Project</li>
            </ol>
        </nav>
    </div>
</div>
<!-- PAGE-HEADER Breadcumbs END -->
@endsection

@section('content')
<!-- Row -->
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Project</h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-danger modal-effect mb-3" data-bs-effect="effect-super-scaled" id="btn-delete">
                    <span class="fe fe-trash"> </span>
                </button>
                <a class="btn btn-primary modal-effect mb-3" data-bs-effect="effect-super-scaled" onclick="create()">
                    <span class="fe fe-plus"> </span>Add 
                </a>
                <table id="datatable" class="table table-bordered text-nowrap border-bottom">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" name="main_chk" id="main_chk"></th>
                            <th>Action</th>
                            <th>Project Name</th>
                            <th>client</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- COL END -->

    <div class="modal fade" id="modal_form">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add new data</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                        <form id="form" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" placeholder="Project name.." value="" name="project_name" class="form-control" id="project_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Client</label>
                            <select name="client_id" id="client_id" class="form-control form-select" required>
                                @foreach ($client as $item)
                                    <option value="{{ $item->id }}">{{ $item->client_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="project_start_date" class="form-label">Project Start Date</label>
                                <input type="date" name="project_start_date" class="form-control" id="project_start_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="project_end_date" class="form-label">Project End Date</label>
                                <input type="date" name="project_end_date" class="form-control" id="project_end_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="project_end_date" class="form-label">Project Status</label>
                                <select name="project_status" id="project_status" class="form-control form-select">
                                    <option value="OPEN">OPEN</option>
                                    <option value="DOING">DOING</option>
                                    <option value="DONE">DONE</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button  id="btnSave" class="btn btn-primary">Simpan</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection

@section('script')

<!-- DATA TABLE JS-->
<script src="{{ asset('virtual/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('virtual/assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>

<script src="{{ asset('virtual/assets/js/script.js') }}"></script>

<script>
    var $table;

    $(document).ready(function() {
        // Contoh Inisiator datatable severside
        table = $("#datatable").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('project-datatable') }}",
            columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, full, meta) {
                    return `
                        <input type="checkbox" name="sub_chk" data-id="${data}" class="sub_chk"/>
                    `;
                }
            },
            {
                targets: [4,5],
                render: function(data, type, full, meta){
                    return moment(data).format('DD MMMM YYYY');
                }
            },
            {
                targets: 2,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html($(td).text())
                    if($(td).text().length > 150) {
                        let txt = $(td).text()
                        $(td).text(txt.substr(0, 150) + '...')
                    }
                },
                
            },
            {
                targets: 1,
                render: function(data, type, full, meta) {
                    return `
                    <div class="btn-list">
                        <a href="javascript:void(0)" onclick="edit('${data}')" class="btn btn-sm btn-primary modal-effect btn-edit" data-bs-effect="effect-super-scaled"><span class="fe fe-edit"> </span></a>
                    </div>
                    `;
                },
            }, ],
            columns: [
                { data: 'id' },
                { data: 'id' },
                { data: 'project_name'},
                { data: 'client.client_name'},
                { data: 'project_start_date' },
                { data: 'project_end_date' },
                { data: 'project_status'}, 
            ]
        });


        $('#btnSave').on('click', function () {
            submit();
        })
        
        $('#form').on('submit', function(e){
            e.preventDefault();

            submit();
        })
        $('#btn-delete').text('Delete('+$('input[name="sub_chk"]:checked').length+')');
        
        $('#main_chk').on('click', function(e){
            if($(this).is(':checked', true)){
                $('.sub_chk').prop('checked', true);
            }else{
                $('.sub_chk').prop('checked', false);
            }
            $('#btn-delete').text('Delete('+$('input[name="sub_chk"]:checked').length+')');
        })

        $(document).on('change', 'input[name="sub_chk"]', function(){
            if($('input[name="sub_chk"]').length == $('input[name="sub_chk"]:checked').length){
                $('#main_chk').prop('checked', true);
            }else{
                $('#main_chk').prop('checked', false);
            }
            $('#btn-delete').text('Delete('+$('input[name="sub_chk"]:checked').length+')');
        })

        //DELETE SELECTED ITEM
        $('#btn-delete').on('click', function(e){
            e.preventDefault();
            var checkedItem = [];
            $('input[name="sub_chk"]:checked').each(function(){
                checkedItem.push($(this).data('id'));
            })

            Swal.fire({
            title: "Yakin ingin menghapus "+checkedItem.length+" data?",
            text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
            icon: "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Ya, Hapus!",
            cancelButtonText  : "Batal"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url    : `{{ route('delete-selected') }}`,
                        type   : "POST",
                        data: { 
                            checkedItem : checkedItem,
                        },
                        dataType: "JSON",
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                }
            })
        })
    });

    function create(){
        submit_method = 'create';

        $('#id').val('');
        $('#form')[0].reset();

        $('#modal_form').modal('show');
        $('.modal-title').text('Add Project');
    }

    function edit(id){
        submit_method = 'edit';

        $('#form')[0].reset();
        var url = "{{ route('project.edit',":id") }}";
        url = url.replace(':id', id);
        
        $.get(url, function (response) {
            response = response.data;
            
            $('#id').val(response.id);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Event Category');

            $('#project_name').val(response.project_name);
            $('#project_start_date').val(response.project_start_date);
            $('#project_end_date').val(response.project_end_date);
            $('#project_status').val(response.project_status).change();
            $('#client_id').val(response.client_id).change();
        });
    }



    function submit() {
        var id = $('#id').val();
        var project_name   = $('#project_name').val();
        var client_id      = $('#client_id option:selected').val();
        var project_start_date      = $('#project_start_date').val();
        var project_end_date      = $('#project_end_date').val();
        var project_status    = $('#project_status option:selected').val();

        var url = "{{ route('project.store') }}";
    
        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);

        if(submit_method == 'edit'){
            url = "{{ route('project.update',":id") }}";
            url = url.replace(':id', id);
        }

        $.ajax({
            url: url,
            type: submit_method == 'create' ? 'POST' : 'PUT',
            dataType: 'json',
            data: {
                id: id,
                project_name: project_name,
                client_id: client_id,
                project_start_date: project_start_date,
                project_end_date: project_end_date,
                project_status: project_status
            },
            success: function (data) {
                if(data.status) {
                    $('#modal_form').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    table.ajax.reload();

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }
                else{
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled',false); //set button enable 
            }, 
            error: function(data){
                var error_message = "";
                error_message += " ";
                
                $.each( data.responseJSON.errors, function( key, value ) {
                    error_message +=" "+value+" ";
                });

                error_message +=" ";
                Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'ERROR !',
                        text: error_message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            },
        });
    }


</script>
@endsection