@extends('dashboard.app')
@section('content')
    <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Create New Post')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Post</li>
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
                    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="postTitle">Post Title</label>
                                <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="postTitle" placeholder="Post title">
                                @error('title')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="excerpt">Post Excerpt</label>
                                <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" placeholder="Post excerpt"></textarea>
                                @error('excerpt')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category">Select Category</label>
                                <select name="category_id" class="form-control @error('category_slug') is-invalid @enderror" id="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subcategory">Select Subcategory</label>
                                <select name="subcategory_id" class="form-control @error('subcategory_slug') is-invalid @enderror" id="subcategory">
                                        <option value="">Select</option>
                                </select>
                                @error('subcategory_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea name="post_content" id="summernote">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <input name="tags" type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" placeholder="Tags">
                                @error('tags')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
                                <input name="thumbnail" type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" id="thumbnail">
                                @error('thumbnail')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control-checkbox" name="status" type="checkbox" id="status">
                                <label for="status"> Publish now</label>
                                @error('status')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Create Post</button>
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
    <!-- Summernote -->
    <script src="{{asset('public/back-end')}}/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            $('#summernote').summernote({
                minHeight: 300
            });
            //toastr message
            @if(Session::get('alert'))
            toastr.{{Session::get('alert')['type']}}('{{Session::get('alert')['message']}}' @if(Session::get('alert')['title']), '{{Session::get('alert')['title']}}'@endif );
            @endif
            //get subcategories by selected category
            const categoryField = document.querySelector('#category');
            const subcategoryField = document.querySelector('#subcategory');
            getSubcategories();
            categoryField.addEventListener('change', getSubcategories);
            function getSubcategories(){
                fetch('http://localhost/laravel-blog/dashboard/get-subcategories/'+categoryField.value)
                    .then(response => response.json())
                    .then(subcategories => {
                        let options = '<option value="">Select</option>';
                        subcategories.forEach(subcategory => {
                            let option = `<option value="${subcategory.id}">${subcategory.subcategory_name}</option>`;
                            options += option;
                        });
                        subcategoryField.innerHTML = options;
                    });
            }
        });
    </script>
@endpush
