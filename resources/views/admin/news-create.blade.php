@extends('layouts.app')

@section('title', 'Добавить новость')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Добавить новость</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.news.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Заголовок</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required
                                   oninput="generateSlug(this.value)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
                            <small class="text-muted">Заполняется автоматически</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Путь к картинке</label>
                            <input type="text" name="image" class="form-control" value="{{ old('image') }}" required>
                            <small class="text-muted">Например: /assets/image/news1.jpg</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Краткое описание</label>
                            <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Полный текст</label>
                            <textarea name="content" class="form-control" rows="8" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news') }}" class="btn btn-secondary">Назад</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Добавить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function generateSlug(title) {
    const slug = title
        .toLowerCase()
        .replace(/[а-яё]/g, c => ({а:'a',б:'b',в:'v',г:'g',д:'d',е:'e',ё:'yo',ж:'zh',з:'z',и:'i',й:'j',к:'k',л:'l',м:'m',н:'n',о:'o',п:'p',р:'r',с:'s',т:'t',у:'u',ф:'f',х:'h',ц:'ts',ч:'ch',ш:'sh',щ:'sch',ъ:'',ы:'y',ь:'',э:'e',ю:'yu',я:'ya'}[c] || c))
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-');
    document.getElementById('slug').value = slug;
}
</script>
@endpush
@endsection
