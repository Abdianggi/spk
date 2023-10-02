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
                            Back
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <button class="btn btn-sm btn-primary float-end">Add new +</button>
                            <table
                                class="table table-md w-100"
                                id="table-product"
                                data-url="{{ route('master.user.datatable') }}"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
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
            let tableId = "#table-product";
    
            $(document).ready(function () {
                $(tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
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
                        { data: "DT_RowIndex", name: "DT_RowIndex" },
                        { data: "name", name: "name" },
                        { data: "username", name: "username" },
                        { data: "email", name: "email" },
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
                })
            });       
            
            $(function(){
                
            })
        </script>
    @endpush
</x-layouts.app>
