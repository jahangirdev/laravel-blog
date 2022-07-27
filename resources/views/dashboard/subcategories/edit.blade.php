@extends('dashboard.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Edit Subcategory')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Subcategory</li>
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
                    <form action="{{route('subcategories.update', $subcategory->id)}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="subcategoryName">Subcategory Name</label>
                                <input name="subcategory_name" type="text" class="form-control @error('subcategory_name') is-invalid @enderror" id="subcategoryName" placeholder="Enter Subcategory Name" value="{{$subcategory->subcategory_name}}">
                                @error('subcategory_name')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subcategorySlug">Subcategory Slug</label>
                                <input name="subcategory_slug" type="text" class="form-control @error('subcategory_slug') is-invalid @enderror" id="subcategorySlug" placeholder="Subcategory Slug"  value="{{$subcategory->subcategory_slug}}">
                                @error('subcategory_slug')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category-name">Select category</label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category-name">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id==$subcategory->category_id) selected @endif>{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Subcategory</button>
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
            //toastr message
            @if(Session::get('alert'))
            toastr.{{Session::get('alert')['type']}}('{{Session::get('alert')['message']}}' @if(Session::get('alert')['title']), '{{Session::get('alert')['title']}}'@endif );
            @endif
        });
    </script>
@endpush
