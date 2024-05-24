@extends('layout.main')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User Clientside</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-12">
          <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-2">Tambah Data</a>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Daftar User ClientSide</h3>


            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-3">
              <table class="table table-hover text-nowrap" id="clientside">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Foto Profil</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($data as $d)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ asset('storage/photo-user/'.$d->image) }}" width="80" alt=""></td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->email }}</td>
                    <td>
                      <a href="{{ route('admin.user.edit', ['id' => $d->id]) }}" class="btn btn-primary"><i
                          class="fas fa-pen"></i> Edit</a>
                      <a href="" data-toggle="modal" data-target="#modal-hapus{{ $d->id }}" class="btn btn-danger"><i
                          class=" fas fa-trash-alt"></i> Hapus</a>
                    </td>
                  </tr>
                  <div class="modal fade" id="modal-hapus{{ $d->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Apakah Anda yakin ingin menghapus data <b>{{ $d->name }}</b></p>
                        </div>

                        <form action="{{ route('admin.user.delete', ['id' => $d->id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
  $(document).ready( function () {
    $('#clientside').DataTable();
} );
</script>
@endsection