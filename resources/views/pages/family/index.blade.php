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
                            class="btn btn-sm btn-primary"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="label-required">Number Electricity Meter </label>
                                    <select id="select2" name="category_id" class="form-control select2">
                                        {{-- @forelse ($electricity as $e)
                                            @once
                                                <option ></option>
                                            @endonce
                                            <option value="{{ $e->number }}">{{ $e->number }}</option>
                                        @empty

                                        @endforelse --}}
                                    </select>
                                </div>
                            </div>
                                <table class="table table-striped mt-2 d-none">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Product</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th id="tName"></th>
                                            <th id="tProduct"></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row d-none">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="kwh" class="label-required">Your Kwh</label>
                                            <input id="kwh" type="number" class="form-control @error('kwh') is-invalid @enderror" name="kwh" required>
                    
                                            @error('kwh')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md col-sm-12">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="total"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                 </div>
                                 <button id="btn-pay" class="btn btn-success d-none float-end mb-3">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('custom_script')
        <script>
            $(function(){
                $('#select2').select2({
                    // placeholder: "Select a customer",
                    // allowClear: true,
                    width: 400
                });
                
                $("#select2").val('').trigger('change')

                var getElectricity = function() {
                    id = $('option:selected').text();
                    // console.log(id);
                    $.ajax({
                        url: '{{ route("master.family.getElectricity") }}',
                        method: 'get',
                        data: {
                            id : id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: async function(response){
                            // $("input[name='name']").val(response.data.name);
                            $("#tName").text(response.data.name);
                            $("#tProduct").text("Rp."+response.data.product.price+" / "+response.data.product.name);
                            $('.d-none').removeClass('d-none')
                            $('#btn-pay').addClass('d-none');
                    
                            convercy = (parseInt(response.data.product.name.replace(' VA', '')) * 0.8)/1000;
                            price    = response.data.product.price;
                        },
                        error: function(e){

                        },
                    });
                }

                var payElectricity = function(){
                    console.log('pay me');
                    id = $('option:selected').text();
                    // console.log(id);
                    $.ajax({
                        url: '{{ route("master.family.payElectricity") }}',
                        method: 'post',
                        data: {
                            id  : id,
                            kwh : $('#kwh').val(),
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response){
                            if (response.status) {
                                Swal.fire({
                                    icon: response.type,
                                    title: response.message,
                                });
                                // Toast.fire({
                                //     icon: 'success',
                                //     title: response.message
                                // });
                            }else{
                                Swal.fire({
                                    icon: response.type,
                                    html: response.message,
                                })
                            }
                        },
                        error: function(e){
                            Toast.fire({
                            icon: 'error',
                            title: e.responseJSON.message
                        });
                        },
                    });
                }

                $(document).on('keyup','#kwh', function(){
                    kwh      = $(this).val();
                    kwhprice = (price/convercy)*1;
                    total    = kwhprice * kwh;

                    $('#total').text('Rp.'+total.toFixed(2));

                    if (kwh <= 0) {
                        $('#btn-pay').addClass('d-none');
                    }else{
                        $('#btn-pay').removeClass('d-none');
                    }
                })
                $(document).on('click','#btn-pay', function(){
                    payElectricity();
                })
                $(document).on('change','#select2', function(){
                    $('#total').text('');
                    $('#kwh').val('');
                    $('#btn-pay').addClass('d-none');

                    getElectricity()
                })
            })        
        </script>
    @endpush
</x-layouts.app>
