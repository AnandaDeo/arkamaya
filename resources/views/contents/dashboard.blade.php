@extends('layout.main')

@section('title', 'project')

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
                <li class="breadcrumb-item active" aria-current="page">Project</li>
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
                <h3 class="card-title">Project</h3>
            </div>
            <div class="card-body">
                <a class="btn btn-primary modal-effect mb-3 data-table-btn ms-4" data-bs-effect="effect-super-scaled" onclick="create()">
                    <span class="fe fe-plus"> </span>Add new data
                </a>
                <table id="datatable" class="table table-bordered text-nowrap border-bottom">
                    <thead>
                        <tr>
                            <th>Option</th>
                            <th>Project Name</th>
                            <th>Client</th>
                            <th>Project Start</th>
                            <th>Project End</th>
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
                        <div class="form-group">
                            <input type="hidden" id="id" name="id">
                            <div class="mb-3">
                                <label for="type" class="form-label">Project Name</label>
                                <input type="text" placeholder="Example : Tahun 2023" value="" name="project_name" class="form-control" id="project_name" value="{{ old('project_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="q1Title" class="form-label">Client</label>
                                <input type="text" placeholder="Q1 title" value="" name="client_id" class="form-control" id="client_id" value="{{ old('client_id') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="q1Desc" class="form-label">Project Start</label>
                                <textarea id="q1Desc" name="project_start">{{ old('project_start') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="q2Title" class="form-label">Project End</label>
                                <input type="text" placeholder="Q2 Title" value="" name="project_end" class="form-control" id="project_end" value="{{ old('q2Title') }}>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="q2Desc" class="form-label">Status</label>
                                <textarea id="q2Desc" name="project_status">{{ old('project_status') }}</textarea>
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

<script src="{{ asset('virtual/assets/js/script.js') }}"></script>

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

<!-- INTERNAL Summernote Editor js -->
<script src="{{ asset('virtual/assets/plugins/summernote-editor/summernote1.js') }}"></script>

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
        ajax: "{{ route('project.datatable') }}",
        columnDefs: [
        // {
        //     targets: 0,
        //     render: function(data, type, full, meta) {
        //         return (meta.row + 1);
        //     }
        // },
        {
            targets: 3,
            createdCell: function(td, cellData, rowData, row, col) {
                $(td).html($(td).text())
                if($(td).text().length > 150) {
                    let txt = $(td).text()
                    $(td).text(txt.substr(0, 150) + '...')
                }
            },

        },
        {
            targets: 5,
            createdCell: function(td, cellData, rowData, row, col) {
                $(td).html($(td).text())
                if($(td).text().length > 150) {
                    let txt = $(td).text()
                    $(td).text(txt.substr(0, 150) + '...')
                }
            },

        },
        {
            targets: 6,
            createdCell: function(td, cellData, rowData, row, col) {
                $(td).html($(td).text())
                if($(td).text().length > 150) {
                    let txt = $(td).text()
                    $(td).text(txt.substr(0, 150) + '...')
                }
            },

        },
        {
            targets: 7,
            createdCell: function(td, cellData, rowData, row, col) {
                $(td).html($(td).text())
                if($(td).text().length > 150) {
                    let txt = $(td).text()
                    $(td).text(txt.substr(0, 150) + '...')
                }
            },

        },
        {
            targets: 0,
            render: function(data, type, full, meta) {
                return `
                <div class="btn-list">
                    <a href="javascript:void(0)" onclick="edit('${data}')" class="btn btn-sm btn-primary modal-effect btn-edit" data-bs-effect="effect-super-scaled"><span class="fe fe-edit"> </span></a>
                    <a href="javascript:void(0)" onclick="destroy('${data}')" class="btn btn-sm btn-danger btn-delete"><span class="fe fe-trash-2"> </span></a>
                </div>
                `;
            },
        }, ],
        columns: [
            { data: null },
            { data: 'project_name'},
            { data: 'client_id'},
            { data: 'project_start'},
            { data: 'project_end'},
            { data: 'project_status'},
        ]
    });

    // $('#btnSave').on('click', function () {
    //     submit();
    // })
    
    $('#form').on('submit', function(e){
        e.preventDefault();

        submit();
    })
});

function create(){
    submit_method = 'create';

    $('#id').val('');
    $('#form')[0].reset();

    $('#modal_form').modal('show');
    $('.modal-title').text('Add Data Roadmap');
    $('#q1Desc').summernote();
    $('#q2Desc').summernote();
    $('#q3Desc').summernote();

    

    $('#btnSave').on('click', function(e) {
        e.preventDefault();

        if($('#q1Desc').summernote('isEmpty'))  alert('Desc Q1 content cannot be null!');
        else if($('#q2Desc').summernote('isEmpty'))  alert('Desc Q2 content cannot be null!');
        else if($('#q3Desc').summernote('isEmpty'))  alert('Desc Q3 content cannot be null!');
        else $('#form').submit();
    })
}

function edit(id){
    submit_method = 'edit';

    $('#form')[0].reset();
    $('#q1Desc').summernote();
    $('#q2Desc').summernote();
    $('#q3Desc').summernote();

    // ajaxSelect2Initiator('category', false, `{{ route('meta.member-category.select2') }}`);

    $('#btnSave').on('click', function(e) {
        e.preventDefault();

        if($('#q1Desc').summernote('isEmpty'))  alert('Desc Q1 content cannot be null!');
        else if($('#q2Desc').summernote('isEmpty'))  alert('Desc Q2 content cannot be null!');
        else if($('#q3Desc').summernote('isEmpty'))  alert('Desc Q3 content cannot be null!');
        else $('#form').submit();
    })

    var url = "{{ route('roadmap.edit',":id") }}";
    url = url.replace(':id', id);
    
    $.get(url, function (response) {
        response = response.data;
        
        $('#id').val(response.id);
        $('#modal_form').modal('show');
        $('.modal-title').text('Edit Data Roadmap');
        // $('#summernote').summernote('code', data.isi);
        $('#type').val(response.type);
        $('#q1Title').val(response.q1_title);
        $('#q1Desc').summernote('code',response.q1_desc);
        $('#q2Title').val(response.q2_title);
        $('#q2Desc').summernote('code', response.q2_desc);
        $('#q3Title').val(response.q3_title);
        $('#q3Desc').summernote('code', response.q3_desc);
    });
}

function submit() {
    var id          = $('#id').val();
    // var regency_id  = $('#city').val();
    var type        = $('#type').val();
    var q1_title        = $('#q1Title').val();
    var q1_desc       = $('#q1Desc').val();
    var q2_title        = $('#q2Title').val();
    var q2_desc        = $('#q2Desc').val();
    var q3_title        = $('#q2Title').val();
    var q3_desc        = $('#q2Desc').val();
    // var username    = $('#username').val();

    var url = "{{ route('roadmap.store') }}";

    $('#btnSave').text('Menyimpan...');
    $('#btnSave').attr('disabled', true);

    if(submit_method == 'edit'){
        url = "{{ route('roadmap.update',":id") }}";
        url = url.replace(':id', id);
    }

    $.ajax({
        url: url,
        type: submit_method == 'create' ? 'POST' : 'PUT',
        dataType: 'json',
        data: {
            id: id,
            type: type,
            q1Title: q1_title,
            q1Desc: q1_desc,
            q2Title: q2_title,
            q2Desc: q2_desc,
            q3Title: q3_title,
            q3Desc: q3_desc,
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

function destroy(id) {
    var url = "{{ route('roadmap.destroy',":id") }}";
    url = url.replace(':id', id);

    Swal.fire({
        title: "Yakin ingin menghapus data ini?",
        text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
        icon: "warning",
        showCancelButton  : true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor : "#d33",
        confirmButtonText : "Ya, Hapus!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url    : url,
                type   : "delete",
                data: { "id":id },
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
} 

</script>
@endsection