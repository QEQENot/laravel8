@extends('layouts.app')

@section('title', 'Категории')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Управление категориями</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Добавить категорию</h5></div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required
                                   oninput="generateSlug(this.value)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="slug" id="slug" class="form-control" required>
                            <small class="text-muted">Заполняется автоматически</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>Добавить
                        </button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Список категорий</h5></div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Slug</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.categories.update', $cat->id) }}" class="d-flex gap-2">
                                        @csrf
                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $cat->name }}" required>
                                        <input type="text" name="slug" class="form-control form-control-sm" value="{{ $cat->slug }}" required>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </td>
                                <td></td>
                                <td>
                                    <a href="{{ route('admin.categories.delete', $cat->id) }}"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Удалить категорию?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
