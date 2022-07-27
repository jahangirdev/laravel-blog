@extends('dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Create New Subcategory')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Subcategory</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- general form elements -->
                <div class="card card-primary">
                    <!-- form start -->
                    <form action="{{route('subcategories.store')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="subcategoryName">Subcategory Name</label>
                                <input name="subcategory_name" type="text" class="form-control @error('subcategory_name') is-invalid @enderror" id="subcategoryName" placeholder="Enter Subcategory Name">
                                @error('subcategory_name')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subcategorySlug">Subcategory Slug</label>
                                <input name="subcategory_slug" type="text" class="form-control @error('subcategory_slug') is-invalid @enderror" id="subcategorySlug" placeholder="Subcategory Slug">
                                @error('subcategory_slug')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category-name">Select category</label>
                                <select name="category_id" class="form-control @error('subcategory_slug') is-invalid @enderror" id="category-name">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('subcategory_slug')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Create Subcategory</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            var slug = document.getElementById('subcategorySlug');
            var name = document.getElementById('subcategoryName');
            name.addEventListener('keyup', ()=>{
                slug.value = name.value.toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            });
            //toastr message
            @if(Session::get('alert'))
            toastr.{{Session::get('alert')['type']}}('{{Session::get('alert')['message']}}' @if(Session::get('alert')['title']), '{{Session::get('alert')['title']}}'@endif );
            @endif
        });
    </script>
@endpush
