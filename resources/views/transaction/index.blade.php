@extends('layout.main')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi</h1>
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
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title mb-3">Daftar Item yang Akan Dibeli</h3>

                </div>
                <div class="card-body">
                  <form action="{{ route('admin.transaction.store') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="id_products">Pilih Menu</label>
                          <select class="form-control" id="id_products">
                            @foreach ($data as $d)
                            <option value="{{ $d->id }}" data-nama="{{ $d->name }}" data-harga="{{ $d->price }}"
                              data-id="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <label for="">&nbsp</label>
                        <button type="button" class="btn btn-primary d-block" onclick="tambahItem()">
                          Tambah Item
                        </button>
                      </div>
                    </div>

                    <table class="table table-hover text-nowrap table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Qty</th>
                          <th>Harga</th>
                          <th>Hapus</th>
                        </tr>
                      </thead>
                      <tbody class="transaksiItem">
                        {{-- @foreach ($dataObjects as $d)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $d->name }}</td>
                          <td>Rp. {{ $d->price }}</td>
                          <td>{{ $d->quantity }}</td>
                          <td>
                            <a href="{{ route('admin.product.edit', ['id' => $d->id]) }}"
                              class="btn btn-sm btn-danger"></i>Hapus</a>
                          </td>
                        </tr>
                        @endforeach --}}
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="2">Jumlah</th>
                          <th class="quantity">0</th>
                          <th class="totalHarga">0</th>
                        </tr>
                      </tfoot>
                    </table>
                    <div class="row mt-3">
                      <div class="col-md-12">
                        <input type="hidden" name="total_harga" value="0">
                        <button class="btn btn-success">Simpan Transaksi</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              </div>
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            {{-- <div class="col-md-6">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Daftar Produk</h3>
                  <div class="card-tools">
                    <form action="{{ route('admin.transaction') }}" method="GET">
                      <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="Search"
                          value="{{ $request->get('search') }}">

                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($data as $d)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->stock }}</td>
                        <td>Rp. {{ $d->price }}</td>
                        <td>
                          <a href="{{ route('admin.transaction.insert', ['id' => $d->id]) }}"
                            class="btn btn-sm btn-secondary"></i>Tambah</a>
                        </td>
                      </tr>

                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div> --}}
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
@section('script')
<script>
  var totalHarga = 0;
      var quantity = 0;
      var listItem = [];

      function tambahItem() {
          updateTotalHarga(parseInt($('#id_products').find(':selected').data('harga')))
          var item = listItem.filter(el => el.id === $('#id_products').find(':selected').data('id'));
          if (item.length > 0) {
              item[0].quantity += 1
          } else {
              var item = {
                  id: $('#id_products').find(':selected').data('id'),
                  name: $('#id_products').find(':selected').data('nama'),
                  price: $('#id_products').find(':selected').data('harga'),
                  quantity: 1
              }
              listItem.push(item)
          }
          updateQuantity(1)
          updateTable()
      }

      function deleteItem(index) {
          var item = listItem[index]
          if (item.quantity > 1) {
              listItem[index].quantity -= 1;
              updateTotalHarga(-(item.price))
              updateQuantity(-1)
          } else {
              listItem.splice(index, 1)
              updateTotalHarga(-(item.price * item.quantity))
              updateQuantity(-(item.quantity))
          }
          updateTable()
      }

      function updateTable() {
          var html = ''
          listItem.map((el, index) => {
              var harga = el.price
              var quantity = el.quantity
              html += `
              <tr>
                  <td>${index + 1}</td>
                  <td>${el.name}</td>
                  <td>${quantity}</td>
                  <td>${harga}</td>
                  <td>
                      <input type="hidden" name="id_daftar[]" value="${el.id}">
                      <input type="hidden" name="quantity[]" value="${el.quantity}">
                      <button type="button" onclick="deleteItem(${index})" class="btn btn-link"><i class="fas fa-fw fa-trash text-danger"></i></button>
                  </td>
              </tr>
              `
          })
          $('.total')
          $('.transaksiItem').html(html)
      }

      function updateTotalHarga(nom) {
          totalHarga = totalHarga + nom;
          $('[name=total_harga]').val(totalHarga)
          $('.totalHarga').html(totalHarga)
      }

      function updateQuantity(nom) {
          quantity = quantity + nom;
          $('.quantity').html(quantity)
      }

      function emptyTable() {
          $('.transaksiItem').html(`
              <tr>
                  <td colspan="4">Belum ada item, silahkan tambahkan</td>
              </tr>
          `)
      }

      $(document).ready(function() {
          emptyTable()
      })
</script>
@endsection