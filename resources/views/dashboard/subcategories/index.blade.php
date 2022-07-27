@extends('dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('All Subcategory')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Subcategory</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with default features</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Subcategory Name</th>
                                        <th>Category Name</th>
                                        <th>Subcategory Slug</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subcategories as $key => $subcategory)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$subcategory->subcategory_name}}</td>
                                        <td>{{$subcategory->category->category_name}}</td>
                                        <td>{{$subcategory->subcategory_slug}}</td>
                                        <td>
                                            <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-info">Edit</a>
                                            <form class="d-inline" action="{{ route('subcategories.destroy', $subcategory->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="delete">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete this subcategory?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        document.addEventListener('DOMContentLoaded', ()=>{
            //toastr message
            @if(Session::get('alert'))
            toastr.{{Session::get('alert')['type']}}('{{Session::get('alert')['message']}}' @if(Session::get('alert')['title']), '{{Session::get('alert')['title']}}'@endif );
            @endif
        });
    </script>
@endpush
