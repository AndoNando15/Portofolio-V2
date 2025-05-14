@extends('layouts.base')
@section('title', 'Gambar Proyek')
@section('subTitle', 'Gambar Proyek')
@section('content')
    <div class="main-container">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Gambar Proyek
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">Tambah
                                Gambar</button>
                        </h6>
                        <div class="filter-container mb-3">
                            <form method="GET" action="{{ route('subProyek.index') }}">
                                <div class="form-row">
                                    <!-- Filter by Proyek ID -->
                                    <div class="col-md-4">
                                        <label for="proyek_id">Filter Proyek</label>
                                        <select name="proyek_id" id="proyek_id" class="form-control">
                                            <option value="">Tampilkan Semua</option>
                                            @foreach ($proyekList as $key => $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    {{ request('proyek_id') == $proyek->id ? 'selected' : '' }}>
                                                    {{ $key + 1 }} - {{ $proyek->judul_proyek }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <!-- Filter by Status -->
                                    <div class="col-md-4">
                                        <label for="status">Filter by Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="Nonaktif"
                                                {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Proyek ID</th>
                                        <th>Gambar Path</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($gambarProyek->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="alert alert-secondary">
                                                    Belum ada data.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($gambarProyek as $key => $gambar)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $gambar->proyek_id }}</td>
                                                <td><img src="{{ asset('images/' . $gambar->gambar_path) }}"
                                                        alt="Gambar Path" width="100" height="auto"> </td>

                                                <td class="text-center">
                                                    <span class="status-label"
                                                        style="background-color: {{ $gambar->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; 
                                                               color: {{ $gambar->status == 'Aktif' ? 'green' : 'red' }}; 
                                                               padding: 5px 10px; font-size: 12px;">
                                                        {{ $gambar->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#showModal-{{ $gambar->id }}">Show</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModal-{{ $gambar->id }}">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal-{{ $gambar->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Show Modal -->
                        @foreach ($gambarProyek as $gambar)
                            <div class="modal fade" id="showModal-{{ $gambar->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="showModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Gambar Proyek</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="proyek-id-show">Proyek ID</label>
                                                    <input type="text" class="form-control" id="proyek-id-show"
                                                        value="{{ $gambar->proyek_id }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="gambar-path-show">Gambar Path</label>
                                                    <img src="{{ asset('images/' . $gambar->gambar_path) }}"
                                                        alt="Gambar Path" width="100" height="auto">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-show">Status</label>
                                                    <input type="text" class="form-control" id="status-show"
                                                        value="{{ $gambar->status }}" readonly
                                                        style="background-color: #d4edda; color: green;">
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
                        <!-- Edit Modal -->
                        @foreach ($gambarProyek as $gambar)
                            <div class="modal fade" id="editModal-{{ $gambar->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Gambar Proyek</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('subProyek.update', $gambar->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group">
                                                    <label for="proyek_id">Proyek ID</label>
                                                    <select name="proyek_id" class="form-control" id="proyek_id"
                                                        required>
                                                        @foreach ($proyekList as $proyek)
                                                            <option value="{{ $proyek->id }}"
                                                                {{ $gambar->proyek_id == $proyek->id ? 'selected' : '' }}>
                                                                {{ $proyek->judul_proyek }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="gambar-edit">Gambar</label>
                                                    <input type="file" class="form-control" id="gambar-edit"
                                                        name="gambar" onchange="previewImageEdit(event)">
                                                    <small>Leave blank if you don't want to change the image.</small>
                                                    <br>
                                                    <img id="gambar-preview-edit"
                                                        src="{{ Storage::url($gambar->gambar_path) }}" alt="Preview"
                                                        style="max-width: 150px; display: block;">
                                                </div>

                                                <div class="form-group">
                                                    <label for="status-edit">Status</label>
                                                    <select class="form-control" id="status-edit" name="status">
                                                        <option value="Aktif"
                                                            {{ $gambar->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                                        </option>
                                                        <option value="Nonaktif"
                                                            {{ $gambar->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
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

                        <script>
                            function previewImageEdit(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('gambar-preview-edit');
                                    output.src = reader.result;
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>


                        <script>
                            function previewImageEdit(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('gambar-preview-edit');
                                    output.src = reader.result;
                                };
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>


                        <!-- Create Modal -->
                        <!-- Create Modal -->
                        <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
                            aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Gambar Proyek</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('subProyek.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="proyek_id">Proyek ID</label>
                                                <select name="proyek_id" class="form-control" id="proyek_id" required>
                                                    <option value="">Select Proyek</option>
                                                    @foreach ($proyekList as $proyek)
                                                        <option value="{{ $proyek->id }}">{{ $proyek->judul_proyek }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="gambar">Upload Gambar</label>
                                                <input type="file" class="form-control" name="gambar" id="gambar"
                                                    onchange="previewImage(event)">
                                                <small>Leave blank if you don't want to change the image.</small>
                                                <br>
                                                <img id="gambar-preview" src="#" alt="Preview"
                                                    style="max-width: 150px; display: none;">
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Nonaktif">Nonaktif</option>
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


                        <script>
                            function previewImage(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('gambar-preview');
                                    output.src = reader.result;
                                    output.style.display = 'block';
                                };
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>


                        <!-- Delete Modal -->
                        @foreach ($gambarProyek as $gambar)
                            <div class="modal fade" id="deleteModal-{{ $gambar->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Gambar Proyek</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this gambar proyek?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('subProyek.destroy', $gambar->id) }}" method="POST">
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

                    </div>
                </div>

            </div>
        </div>
        <!-- Row end -->

        {{-- Tech --}}
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Tech
                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                data-target="#createModalTech">Tambah
                                Tech</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tech</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tech->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="alert alert-secondary">
                                                    Belum ada data.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($tech as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $item->tech }}</td>
                                                <td class="text-center">
                                                    <span class="status-label"
                                                        style="background-color: {{ $item->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; 
                                                           color: {{ $item->status == 'Aktif' ? 'green' : 'red' }}; 
                                                           padding: 5px 10px; font-size: 12px;">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#showModalTech-{{ $item->id }}">Show</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModalTech-{{ $item->id }}">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModalTech-{{ $item->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Create Modal -->
                        <div class="modal fade" id="createModalTech" tabindex="-1" role="dialog"
                            aria-labelledby="createModalLabelTech" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Tech</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tech.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="tech-create">Tech</label>
                                                <input type="text" class="form-control" id="tech-create"
                                                    name="tech" placeholder="Masukkan tech">
                                            </div>
                                            <div class="form-group">
                                                <label for="status-create">Status</label>
                                                <select class="form-control" id="status-create" name="status">
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Nonaktif">Nonaktif</option>
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

                        <!-- Edit Modal -->
                        @foreach ($tech as $item)
                            <div class="modal fade" id="editModalTech-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabelTech" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Tech</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('tech.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="tech-edit">Tech</label>
                                                    <input type="text" class="form-control" id="tech-edit"
                                                        name="tech" value="{{ $item->tech }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-edit">Status</label>
                                                    <select class="form-control" id="status-edit" name="status">
                                                        <option value="Aktif"
                                                            {{ $item->status == 'Aktif' ? 'selected' : '' }}>
                                                            Aktif</option>
                                                        <option value="Nonaktif"
                                                            {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>
                                                            Nonaktif</option>
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
                        <!-- Show Modal -->
                        @foreach ($tech as $item)
                            <div class="modal fade" id="showModalTech-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="showModalLabelTech" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Tech</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="tech-show">Tech</label>
                                                    <input type="text" class="form-control" id="tech-show"
                                                        value="{{ $item->tech }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-show">Status</label>
                                                    <input type="text" class="form-control" id="status-show"
                                                        value="{{ $item->status }}" readonly
                                                        style="background-color: #d4edda; color: green;">
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
                        <!-- Delete Modal -->
                        @foreach ($tech as $item)
                            <div class="modal fade" id="deleteModalTech-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="deleteModalLabelTech" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Tech</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this tech?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('tech.destroy', $item->id) }}" method="POST">
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

                    </div>
                </div>

            </div>
        </div>
        <!-- Row end -->
    </div>
@endsection
