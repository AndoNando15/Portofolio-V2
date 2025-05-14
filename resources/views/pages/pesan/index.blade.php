@extends('layouts.base')
@section('title', 'Pesan')
@section('subTitle', 'Pesan')

@section('content')
    <div class="main-container">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Pesan Masuk
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">
                                Tambah Pesan
                            </button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Subjek</th>
                                        <th>Isi Pesan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Balasan</th> <!-- New Column -->
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($pesan->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="alert alert-warning">
                                                    Belum ada pesan.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($pesan as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->no_telepon }}</td>
                                                <td>{{ $item->subjek }}</td>
                                                <td>{!! $item->isi_pesan !!}</td>
                                                <td class="text-center">
                                                    <span class="status-label"
                                                        style="background-color: {{ $item->status == 'Sudah Dibalas' ? '#d4edda' : '#f8d7da' }}; color: {{ $item->status == 'Sudah Dibalas' ? 'green' : 'red' }}; padding: 5px 10px; font-size: 12px;">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->status == 'Belum Dibalas')
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#balasModal-{{ $item->id }}">Balas</button>
                                                    @else
                                                        <span>{{ $item->balasan }}</span>
                                                        <!-- Show response if already answered -->
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Action buttons -->
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#showModal-{{ $item->id }}">Show</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModal-{{ $item->id }}">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal-{{ $item->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                        </div>

                        <!-- Show Modal -->
                        @foreach ($pesan as $item)
                            <div class="modal fade" id="showModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="showModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pesan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="nama-show">Nama</label>
                                                    <input type="text" class="form-control" id="nama-show"
                                                        value="{{ $item->nama }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email-show">Email</label>
                                                    <input type="text" class="form-control" id="email-show"
                                                        value="{{ $item->email }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="no_telepon-show">No Telepon</label>
                                                    <input type="text" class="form-control" id="no_telepon-show"
                                                        value="{{ $item->no_telepon }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="subjek-show">Subjek</label>
                                                    <input type="text" class="form-control" id="subjek-show"
                                                        value="{{ $item->subjek }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="isi_pesan-show">Isi Pesan</label>
                                                    <textarea class="form-control" id="isi_pesan-show" rows="3" readonly>{{ $item->isi_pesan }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-show">Status</label>
                                                    <input type="text" class="form-control" id="status-show"
                                                        value="{{ $item->status }}" readonly
                                                        style="background-color: {{ $item->status == 'Sudah Dibalas' ? '#d4edda' : '#f8d7da' }}; color: {{ $item->status == 'Sudah Dibalas' ? 'green' : 'red' }};">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Edit Modal -->
                        @foreach ($pesan as $item)
                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Pesan</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pesan.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="nama-edit">Nama</label>
                                                    <input type="text" class="form-control" id="nama-edit"
                                                        name="nama" value="{{ $item->nama }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email-edit">Email</label>
                                                    <input type="text" class="form-control" id="email-edit"
                                                        name="email" value="{{ $item->email }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="no_telepon-edit">No Telepon</label>
                                                    <input type="text" class="form-control" id="no_telepon-edit"
                                                        name="no_telepon" value="{{ $item->no_telepon }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="subjek-edit">Subjek</label>
                                                    <input type="text" class="form-control" id="subjek-edit"
                                                        name="subjek" value="{{ $item->subjek }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="isi_pesan-edit">Isi Pesan</label>
                                                    <textarea class="form-control" id="isi_pesan-edit-{{ $item->id }}" name="isi_pesan" rows="3">{{ $item->isi_pesan }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-edit">Status</label>
                                                    <select class="form-control" id="status-edit" name="status">
                                                        <option value="Sudah Dibalas"
                                                            {{ $item->status == 'Sudah Dibalas' ? 'selected' : '' }}>Sudah
                                                            Dibalas</option>
                                                        <option value="Belum Dibalas"
                                                            {{ $item->status == 'Belum Dibalas' ? 'selected' : '' }}>
                                                            Belum Dibalas
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Simpan
                                                        Perubahan</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Create Modal -->
                        <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
                            aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Pesan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('pesan.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama-create">Nama</label>
                                                <input type="text" class="form-control" id="nama-create"
                                                    name="nama" placeholder="Masukkan nama">
                                            </div>
                                            <div class="form-group">
                                                <label for="email-create">Email</label>
                                                <input type="email" class="form-control" id="email-create"
                                                    name="email" placeholder="Masukkan email">
                                            </div>
                                            <div class="form-group">
                                                <label for="no_telepon-create">No Telepon</label>
                                                <input type="text" class="form-control" id="no_telepon-create"
                                                    name="no_telepon" placeholder="Masukkan nomor telepon">
                                            </div>
                                            <div class="form-group">
                                                <label for="subjek-create">Subjek</label>
                                                <input type="text" class="form-control" id="subjek-create"
                                                    name="subjek" placeholder="Masukkan subjek">
                                            </div>
                                            <div class="form-group">
                                                <label for="isi_pesan-create">Isi Pesan</label>
                                                <textarea class="form-control" id="isi_pesan-create" name="isi_pesan" rows="3"
                                                    placeholder="Masukkan isi pesan"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="status-create">Status</label>
                                                <select class="form-control" id="status-create" name="status">
                                                    <option value="Sudah Dibalas">Sudah Dibalas</option>
                                                    <option value="Belum Dibalas">Belum Dibalas</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Delete Modal -->
                        @foreach ($pesan as $item)
                            <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Pesan</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this message?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('pesan.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- balas modal --}}
                        @foreach ($pesan as $item)
                            <div class="modal fade" id="balasModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="balasModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Balas Pesan</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pesan.balas', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="balasan">Balasan</label>
                                                    <textarea class="form-control" id="balasan" name="balasan" rows="3" placeholder="Masukkan balasan"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
        <!-- Row end -->
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        // Initialize CKEditor for the 'create' form textarea
        ClassicEditor
            .create(document.querySelector('#isi_pesan-create'))
            .catch(error => {
                console.error(error);
            });

        // Initialize CKEditor for the 'edit' form textarea for each error
        @foreach ($pesan as $item)
            ClassicEditor
                .create(document.querySelector('#isi_pesan-edit-{{ $item->id }}'))
                .catch(error => {
                    console.error(error);
                });
        @endforeach
    </script>

@endsection
