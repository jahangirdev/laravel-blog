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
                                        <th>Post title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $key => $post)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->category->category_name}}@if($post->subcategory) <i class="fa fa-angle-double-right"></i> {{$post->subcategory->subcategory_name}} @endif</td>
                                        <td>{{$post->user->name}}</td>
                                        <td>{{$post->post_date}}</td>
                                        <td>
                                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-success">View</a>
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info">Edit</a>
                                            <form class="d-inline" action="{{ route('posts.destroy', $post->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="delete">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete this post?')">Delete</button>
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
