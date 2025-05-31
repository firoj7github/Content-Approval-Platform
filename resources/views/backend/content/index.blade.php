@extends('backend.layouts.app')

@section('content')
<style>
    .faqs_table {
        overflow: auto;
    }
</style>
<div class="row">


    {{-- news edit modal close --}}
    <div class="col-md-12"
        <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List</h3>

            </div>
            <!-- /.card-header -->
            <div style="overflow-y:auto" class="card-body">
                <table class="table table-bordered table-striped post_table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>

                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card-body -->
        <!-- /.card -->
        </section>
    </div>
</div>
@endsection

@push('js')
<script>
    // description editor js start





    $(document).ready(function() {



        $(function() {

            var table = $('.post_table').DataTable({

                dom: "lBfrtip",
                buttons: ["copy", "csv", "excel", "pdf", "print"],

                pageLength: 25,
                processing: true,
                serverSide: true,
                searchable: true,
                "ajax": {
                    "url": "{{ route('admin.posts.index') }}",
                    "datatype": "json",
                    "dataSrc": "data",
                    "data": function(data) {

                    }
                },

                drawCallback: function(settings) {

                    $('#is_check_all').prop('checked', false);

                },

                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                        sWidth: '3%'
                    },

                    {
                        data: 'image',
                        name: 'image',
                        sWidth: '15%'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        sWidth: '40%'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        sWidth: '10%'
                    },



                    {
                        data: 'action',
                        name: 'action',
                        sWidth: "5%",
                        orderable: false,
                        searchable: false
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "All"]
                ],
            });
            table.buttons().container().appendTo('#exportButtonsContainer');

            $(document.body).on('click', '#is_check_all', function(event) {
                alert('Checkbox clicked!');
                var checked = event.target.checked;
                if (true == checked) {
                    $('.check1').prop('checked', true);
                }
                if (false == checked) {
                    $('.check1').prop('checked', false);
                }
            });

            $('#is_check_all').parent().addClass('text-center');

            $(document.body).on('click', '.check1', function(event) {

                var allItem = $('.check1');

                var array = $.map(allItem, function(el, index) {
                    return [el]
                })

                var allChecked = array.every(isSameAnswer);

                function isSameAnswer(el, index, arr) {
                    if (index === 0) {
                        return true;
                    } else {
                        return (el.checked === arr[index - 1].checked);
                    }
                }

                if (allChecked && array[0].checked) {
                    $('#is_check_all').prop('checked', true);
                } else {
                    $('#is_check_all').prop('checked', false);
                }
            });

            //Submit filter form by select input changing
            $(document).on('change', '.submitable', function() {

                table.ajax.reload();

            });


        });




        $(document).on('change', '.status-select', function() {
            let select = $(this);
            let id = select.data('id');
            let status = select.val();

            $.ajax({
                url: `/admin/posts/${id}/change-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    id: id
                },
                success: function(res) {
                    toastr.success(res.message);
                    // Remove previous classes
                    select.removeClass('select-status-approved select-status-rejected select-status-pending');
                    // Add new class
                    select.addClass('select-status-' + status);
                },
                error: function() {
                    toastr.error("Failed to update status");
                }
            });
        });



















    });

    // news edit code
</script>
@endpush