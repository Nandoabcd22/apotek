@extends('layouts.app')

@section('title', 'Daftar Apoteker')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Dashboard</a> / Daftar Apoteker
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h1>Daftar Apoteker</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Apoteker
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-info" title="Lihat">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data apoteker</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus apoteker ini?')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}
</script>
@endsection
