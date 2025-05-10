@extends('layouts.base')
@section('title', 'Tentang Kami')
@section('subTitle', 'Tentang Kami')

@section('content')
    <div class="main-container">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Tentang Kami
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">Tambah
                                Data</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Pekerjaan</th>
                                        <th>Deskripsi CV</th>
                                        <th>File CV</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tentangKami->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-secondary">
                                                    Belum ada data.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($tentangKami as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $item->nama_lengkap }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                                <td>{{ $item->deskripsi_cv }}</td>
                                                <td>
                                                    @if ($item->file_cv)
                                                        <a href="{{ asset('storage/' . $item->file_cv) }}" target="_blank"
                                                            class="btn btn-info btn-sm">View PDF</a>
                                                    @else
                                                        <span>No File</span>
                                                    @endif
                                                </td>
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
                        @foreach ($tentangKami as $item)
                            <div class="modal fade" id="showModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="showModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Tentang Kami</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="nama_lengkap-show">Nama Lengkap</label>
                                                    <input type="text" class="form-control" id="nama_lengkap-show"
                                                        value="{{ $item->nama_lengkap }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pekerjaan-show">Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pekerjaan-show"
                                                        value="{{ $item->pekerjaan }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="deskripsi_cv-show">Deskripsi CV</label>
                                                    <input type="text" class="form-control" id="deskripsi_cv-show"
                                                        value="{{ $item->deskripsi_cv }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_cv-show">File CV</label>
                                                    @if ($item->file_cv)
                                                        <a href="{{ asset('storage/' . $item->file_cv) }}" target="_blank"
                                                            class="btn btn-info btn-sm">View PDF</a>
                                                    @else
                                                        <span>No File</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-show">Status</label>
                                                    <span
                                                        class="badge {{ $item->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $item->status }}
                                                    </span>
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
                        @foreach ($tentangKami as $item)
                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Tentang Kami</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('tentang-kami.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="nama_lengkap-edit">Nama Lengkap</label>
                                                    <input type="text" class="form-control" id="nama_lengkap-edit"
                                                        name="nama_lengkap" value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="pekerjaan-edit">Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pekerjaan-edit"
                                                        name="pekerjaan" value="{{ $item->pekerjaan }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="deskripsi_cv-edit">Deskripsi CV</label>
                                                    <input type="text" class="form-control" id="deskripsi_cv-edit"
                                                        name="deskripsi_cv" value="{{ $item->deskripsi_cv }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_cv-edit">File CV</label>
                                                    <input type="file" class="form-control" id="file_cv-edit"
                                                        name="file_cv">
                                                    <small>Leave blank to keep existing file</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-edit">Status</label>
                                                    <select class="form-control" id="status-edit" name="status">
                                                        <option value="Aktif"
                                                            {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Nonaktif"
                                                            {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
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
                                        <h5 class="modal-title">Tambah Data Tentang Kami</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tentang-kami.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama_lengkap-create">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="nama_lengkap-create"
                                                    name="nama_lengkap" placeholder="Masukkan nama lengkap">
                                            </div>
                                            <div class="form-group">
                                                <label for="pekerjaan-create">Pekerjaan</label>
                                                <input type="text" class="form-control" id="pekerjaan-create"
                                                    name="pekerjaan" placeholder="Masukkan pekerjaan">
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi_cv-create">Deskripsi CV</label>
                                                <input type="text" class="form-control" id="deskripsi_cv-create"
                                                    name="deskripsi_cv" placeholder="Masukkan deskripsi CV">
                                            </div>
                                            <div class="form-group">
                                                <label for="file_cv-create">File CV (PDF)</label>
                                                <input type="file" class="form-control" id="file_cv-create"
                                                    name="file_cv" accept="application/pdf">
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

                        <!-- Delete Modal -->
                        @foreach ($tentangKami as $item)
                            <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Tentang Kami</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this record?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('tentang-kami.destroy', $item->id) }}" method="POST">
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

        {{-- Tabel Gambar --}}
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Gambar
                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                data-target="#createModalGambar">Tambah
                                Data</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tentangKamiGambar->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <div class="alert alert-secondary">
                                                    Belum ada data.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($tentangKamiGambar as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>
                                                    @foreach (json_decode($item->gambar) as $image)
                                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                                            width="100">
                                                    @endforeach
                                                </td>
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
                                                        data-target="#showModalGambar-{{ $item->id }}">Show</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModalGambar-{{ $item->id }}">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModalGambar-{{ $item->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Show Modal -->
                        <!-- Show Modal -->
                        @foreach ($tentangKamiGambar as $item)
                            <div class="modal fade" id="showModalGambar-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="showModalLabelGambar" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Gambar</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>Gambar</h6>
                                            <div class="row">
                                                @foreach (json_decode($item->gambar) as $image)
                                                    <div class="col-md-4 mb-3">
                                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid"
                                                            alt="image preview">
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Display Status -->
                                            <h6>Status</h6>
                                            <span
                                                class="badge {{ $item->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $item->status }}
                                            </span>
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
                        @foreach ($tentangKamiGambar as $item)
                            <div class="modal fade" id="editModalGambar-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabelGambar" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Gambar</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('tentang-kami-gambar.update', $item->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <h6>Existing Gambar</h6>
                                                <div class="row mb-3">
                                                    @foreach (json_decode($item->gambar) as $image)
                                                        <div class="col-md-4">
                                                            <img src="{{ asset('storage/' . $image) }}"
                                                                class="img-fluid mb-2" alt="existing image">
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="form-group">
                                                    <label for="gambar-edit">Upload New Gambar</label>
                                                    <input type="file" class="form-control" id="gambar-edit"
                                                        name="gambar[]" multiple onchange="previewImages(event)">
                                                    <small>Leave blank to keep existing images</small>
                                                </div>

                                                <div id="image-preview" class="mb-3"></div>

                                                <!-- Status Field -->
                                                <div class="form-group">
                                                    <label for="status-edit">Status</label>
                                                    <select class="form-control" id="status-edit" name="status">
                                                        <option value="Aktif"
                                                            {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Nonaktif"
                                                            {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
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
                        <!-- Create Modal -->
                        <div class="modal fade" id="createModalGambar" tabindex="-1" role="dialog"
                            aria-labelledby="createModalLabelGambar" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Gambar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tentang-kami-gambar.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="gambar-create">Gambar</label>
                                                <input type="file" class="form-control" id="gambar-create"
                                                    name="gambar[]" multiple accept="image/*"
                                                    onchange="previewImages(event)">
                                                <small>Max 13 images allowed. Only image files (JPG, JPEG, PNG, GIF) are
                                                    allowed.</small>
                                            </div>

                                            <div id="image-preview-create" class="mb-3"></div>

                                            <!-- Status Field -->
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


                        <!-- Delete Modal -->
                        @foreach ($tentangKamiGambar as $item)
                            <div class="modal fade" id="deleteModalGambar-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="deleteModalLabelGambar" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Gambar</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete these images?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('tentang-kami-gambar.destroy', $item->id) }}"
                                                method="POST">
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
    <!-- Image Preview Script -->
    <script>
        function previewImages(event) {
            const previewContainer = event.target.id === 'gambar-create' ? document.getElementById('image-preview-create') :
                document.getElementById('image-preview');
            previewContainer.innerHTML = ''; // Clear the current preview
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = '100px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(files[i]);
            }
        }
    </script>
@endsection
