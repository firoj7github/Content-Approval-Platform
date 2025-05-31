@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="bg-white p-4 rounded-lg">
        <h1 class="mb-4">Create New Post</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('posts.store') }}" method="post" id="PostCreate" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control rounded">
                <span class="text-danger error-message" id="title-error"></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    <option selected>Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-message" id="category_id-error"></span>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" rows="5" class="form-control">{{ old('content') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tags (comma separated)</label>
                <input type="text" name="tags" value="{{ old('tags') }}" class="form-control" placeholder="e.g. Movie, Natok">
            </div>

            <div class="mb-3">
                <label class="form-label">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
                <span class="text-danger error-message" id="image-error"></span>
            </div>

            <button type="submit" class="btn btn-primary">Submit Post</button>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#PostCreate').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(this);

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    $('.error-message').html('');
                    if (res.errors) {
                        $.each(res.errors, function(key, value) {
                            $('#' + key + '-error').html(value[0]);
                        });
                    } else if (res.status == 'success') {
                        toastr.success(res.message);
                        form.reset();
                    }
                },
                error: function(xhr) {
                    $('.error-message').html('');
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '-error').text(value[0]);
                    });
                }
            })
        });
    });
</script>
@endpush