@extends('master')

@section('judul')

@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        
        @if(!empty($lelangs))
      <div class="row">
        <div class="col-md-5">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
               @if($lelangs->barang->image)
                <img class="img-fluid mt-3" src="{{ asset('storage/' . $lelangs->barang->image)}}" alt="User profile picture">
                @endif
            </div>
        
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        
        <!-- /.col -->
        <div class="col-md-7">
          <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Details Barang</a></li>
                    @if( Auth::user()->level == 'masyarakat')
                    <li class="nav-item"><a class="nav-link" href="#bid" data-toggle="tab">Tawar</a></li>
                    @else
                    @endif
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                @if( Auth::user()->level == 'masyarakat')
                <div class="tab-pane" id="bid">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName">Tawarkan Harga </label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" placeholder="Masukan Harga harus lebih dari {{ $lelangs->harga_akhir }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="">
                          <button type="submit" class="btn btn-danger">Tawarkan</button>
                        </div>
                    </div>
                    </form>
                  </div>
                  @else
                  @endif
                <div class="tab-pane active" id="details">
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label for="inputName">Nama Barang</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="inputName" value="{{ $lelangs->barang->nama_barang}}"disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail">Harga Awal</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="inputEmail" value="@currency($lelangs->barang->harga_awal)"disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail">Harga akhir</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="inputEmail" value="@currency($lelangs->harga_akhir)"disabled>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputName2">Tanggal Lelang</label>
                           <div class="col-sm-12">
                            <input type="text" class="form-control" id="inputName2" value="{{ \Carbon\Carbon::parse($lelangs->tanggal_lelang)->format('j F Y')}}" disabled>
                           </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail">Status</label>
                            <div class="col-sm-12">
                             <input type="text" class="form-control" id="inputEmail" value="{{ $lelangs->status}}"disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="inputExperience">Deskripsi Barang</label>
                      <div class="col-sm-12">
                        <textarea class="form-control" id="inputExperience" disabled>{{ $lelangs->barang->deskripsi_barang}}</textarea>
                      </div>
                    </div>
                    @if(auth()->user()->level == 'admin')
                  <a href="{{route('lelangadmin.index')}}" class="btn btn-outline-info">Kembali</a>
                  @elseif(auth()->user()->level == 'masyarakat')
                  <a href="{{route('dashboard.masyarakat')}}" class="btn btn-outline-info">Kembali</a>
                    @elseif(auth()->user()->level == 'petugas')
                    <a href="{{ route('lelangpetugas.index')}}" class="btn btn-outline-info">Kembali</a>
                  @endif
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        {{-- <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                  <div class="card-body">
    
                </div>
              </div>
            </div>
        </div> --}}
        <!-- /.col -->
      </div>
      @endif
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="card">
      <div class="card-header">
  
      
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
    <table class="table table-hover">
          <thead>
              <tbody>
                  <tr>
                      <th>No</th>
                      <th>Pelelang</th>
                      <th>Nama Barang</th>
                      <th>Harga Penawaran</th>
                      <th>Tanggal Penawaran</th>
                      <th>Status</th>
                      @if(auth()->user()->level == 'petugas')
                      <th></th>
                      @else
                      @endif
                      @if(auth()->user()->level == 'admin')
                      <th></th>
                      @else
                      @endif
                      
                  </tr>
              </tbody>
          </thead>
          @forelse ($historyLelangs as $item)
          <tbody>
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->user->name }}</td>
              <td>{{ $item->nama_barang }}</td>
              <td>@currency($item->harga)</td>
              <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('j-F-Y') }}</td>
              <td>
                <span class="badge {{ $item->status == 'pending' ? 'bg-warning' : 'bg-success' }}">{{ Str::title($item->status) }}</span>
              </td>
              <td>
                <a class="btn btn-success btn-sm" href="{{ route('lelangpetugas.show', $item->id)}}">
                  <i class="fas fa-check">
                  </i>
                  Pilih Jadi Pemenang
              </a>
              </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align: center" class="text-danger"><strong>Belum ada penawaran</strong></td>
          </tr>
          @endforelse
          </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    <!-- /.card-footer-->
  </div>
  </section>
@endsection