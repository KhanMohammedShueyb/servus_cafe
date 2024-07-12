@extends('superadmin.layouts.default')

@section('title', 'Sandwiches')
@section('content')
<div class="main-content container">
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="">
                <h3 class="card-label">Sandwiches</h3>
                <div class="form-group">
                    <label for="tenant_filter">Filter by School:</label>
                    <select id="tenant_filter" class="form-control">
                        <option value="">All Schools</option>
                        @foreach ($all_tenants as $tenant)
                        <option value="{{ $tenant->id }}">{{ $tenant->tenant_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert"> {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger" role="alert"> {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <table class="table table-bordered table-hover" id="superadmin_tenant_datatable">
                <thead>
                    <tr>
                        <th title="Field #1">Sandwich ID</th>
                        <th title="Field #2">School Name</th>
                        <th title="Field #2">Sandwich Name</th>
                        <th title="Field #3">Sandwich Note</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_sandwiches as $single_sandwich)
                    <tr>
                        <td>{{ $single_sandwich->id }}</td>
                        <td>{{ $single_sandwich->tenant->tenant_name }}</td>
                        <td>{{ $single_sandwich->sandwich_name }}</td>
                        <td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@stop
@section('scripts')
   
<script>
        var dataTable = $('#superadmin_tenant_datatable').DataTable({
            fixedColumns: true
        });
        $('#tenant_filter').on('change', function () {
            var selectedTenantId = $(this).val();
            if (selectedTenantId) {
                $.ajax({
                    url: 'sandwich',
                    method: 'GET',
                    data: { tenant_id: selectedTenantId },
                    success: function (data) {
                        dataTable.columns(2).search('').draw();
                        dataTable.clear().draw();
                        for (var i = 0; i < data.length; i++) {
                            dataTable.row.add([
                                data[i].id,
                                data[i].tenant.tenant_name,
                                data[i].sandwich_name,
                                data[i].note
                            ]).draw(false);
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching data.');
                    }
                });
            } else {
                dataTable.columns(2).search('').draw();
            }
        });
</script>
@endsection