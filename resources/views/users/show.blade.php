@extends('layouts.app')

@section('title', 'Detail Apoteker')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('admin.users.index') }}">Daftar Apoteker</a> / Detail Apoteker
@endsection

@section('content')
<div class="page-header">
    <h1>Detail Apoteker</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama</label>
                    <p class="form-control-plaintext">{{ $user->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p class="form-control-plaintext">{{ $user->email }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Role</label>
                    <p class="form-control-plaintext"><span class="badge bg-success">{{ ucfirst($user->role) }}</span></p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Terdaftar Sejak</label>
                    <p class="form-control-plaintext">{{ $user->created_at->format('d M Y H:i') }}</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button class="btn btn-danger" onclick="deleteUser()">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteUser() {
    if (confirm('Apakah Anda yakin ingin menghapus apoteker ini?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection
