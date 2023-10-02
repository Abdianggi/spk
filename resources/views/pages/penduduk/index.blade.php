<x-layouts.app
    :title="$title"
>
    <section id="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a
                            href="{{ url()->previous() }}"
                            class="btn btn-sm btn-white"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>


                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl verybigmodal">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Penduduk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="form-penduduk" enctype="multipart/form-data">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap datatable">
                                                <thead>
                                                    <tr>
                                                    <th>No KK</th>
                                                    <th>Nama Kepala Keluarga</th>
                                                    <th>Alamat</th>
                                                    <th><button id="addVariant" type="button" class="btn btn-success"><i class="bi bi-plus"></i></button></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                    <tr class="tr-variant">
                                                        <td><input type="text" class="form-control" name="penduduk_nokk[]"></td>
                                                        <td><input type="text" class="form-control" name="penduduk_namakepala[]"></td>
                                                        <td><input type="text" class="form-control" name="penduduk_alamat[]"></td>
                                                        <td><button type="button" class="btn btn-danger delete-variant"><i class="bi bi-trash"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btnCancelModal" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary btnAddGuest">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah +</button>
                            <table
                                class="table table-md w-100"
                                id="table"
                                data-url="{{ route('master.penduduk.datatable') }}"
                            >
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>No KK</th>
                                        <th>Kepala Keluarga</th>
                                        <th>Alamat</th>
                                        <th>Ditambahkan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('custom_script')
        <script>
            let tableId = "#table";
    
            $(document).ready(function () {
                $(tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    lengthChange: true,
                    responsive: true,
                    ordering: true,
                    language: {
                        processing: "Loading",
                    },
                    ajax: {
                        url: $(tableId).data("url"),
                    },
                    columns: [
                        { data: "action", name: "action", orderable: false, searchable: false, width: '12%' },
                        { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                        { data: "no_kk", name: "no_kk" },
                        { data: "nama_kepala_keluarga", name: "nama_kepala_keluarga" },
                        { data: "alamat", name: "alamat" },
                        { data: "created_at", name: "created_at" },
                    ],
                    columnDefs: [
                        {
                            targets: [0],
                            orderable: false,
                            searchable: false
                        },
                        {
                            targets: [1],
                        },
                        {
                            targets: [2],
                        },
                    ],
                    language: {
                            "sProcessing": "Sebentar",
                            "sLengthMenu": "Tampilkan _MENU_ Data",
                            "sZeroRecords": "Tidak ada data",
                            "sInfo": "Menampilkan _START_ Sampai _END_ Dari _TOTAL_ Data",
                            "sInfoEmpty": "0 Data",
                            // "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                            "sInfoPostFix": "",
                            "sSearch": "Cari :",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Pertama",
                                "sPrevious": "Sebelumnya",
                                "sNext": "Selanjutnya",
                                "sLast": "Terakhir"
                            }
                        }
                })
            });       
            
            $(function(){
                $(document).ready(function(){
                    $(document).on('click', '#addVariant', function(){
                        if ($('.tr-variant').length >= 100) {
                            Swal.fire({
                                html : 'Already maximum capacity!',
                            })
                        }else{
                            $('#tableBody').append(`
                            <tr class="tr-variant">
                                <td><input type="text" class="form-control" name="penduduk_nokk[]"></td>
                                <td><input type="text" class="form-control" name="penduduk_namakepala[]"></td>
                                <td><input type="text" class="form-control" name="penduduk_alamat[]"></td>
                                <td><button type="button" class="btn btn-danger delete-variant"><i class="bi bi-trash"></i></button></td>
                            </tr>
                            `)
                        }
                    })
                    $(document).on('click', '.delete-variant', function () {
                        if ($('.tr-variant').length == 1) {
                            Swal.fire({
                                html : 'Setidaknya harus ada 1!',
                            })
                        }else{
                            $(this).closest('.tr-variant').remove();
                        }
                    })
                    
                    $(document).on('click', '.btnAddGuest', function(){
                        addNewguest();
                    })

                    var addNewguest = function(){
                        // let formData = $('#form-penduduk').serialize();
                        let formData = new FormData($('#form-penduduk')[0]);
                        $.ajax({
                            url: '{{ route('master.penduduk.store') }}',
                            method: 'POST',
                            data : formData,
                            contentType : false,
                            processtType : false,
                            processData : false,
                            success: function(response){
                                console.log('asu banget');
                                if (response.status) {
                                    $('#form-penduduk').trigger('reset');
                                    $('#exampleModal').modal('toggle');
                                    $('#table').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: response.type,
                                        title: response.message,
                                    });
                                }else{
                                    Swal.fire({
                                        icon: response.type,
                                        html: response.message,
                                    })
                                }
                            }
                        })
                    }

                    $(document).on('click','.btn-delete', function(){
                        id = $(this).attr('data-id');

                        Swal.fire({
                            // title: 'Are you sure?',
                            text: "Yakin ingin menghapus?",
                            // icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.value) {
                                let url = '{{ route('master.penduduk.destroy', ':id') }}';
                                    url = url.replace(':id', id);
                                    console.log(url);

                                $.ajax({
                                    url : url,
                                    type : 'delete',
                                    data : {
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function(response){
                                        if(response.status){
                                            Toast.fire({
                                                // icon: 'success',
                                                title: response.message
                                            });
                                        }else{
                                            Toast.fire({
                                                // icon: 'error',
                                                title: response.message
                                            });
                                        }

                                        // table.ajax.reload();
                                        $('#table').DataTable().ajax.reload();
                                    },
                                    error: function(e){
                                        Toast.fire({
                                            // icon: 'error',
                                            title: e.responseJSON.message
                                        });
                                    }
                                });
                            }
                        })
                    })
                })
            })
        </script>
    @endpush
</x-layouts.app>
