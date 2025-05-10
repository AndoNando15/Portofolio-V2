@extends('layouts.base')
@section('title', 'Kontak')
@section('subTitle', 'Kontak')

@section('content')
    <div class="main-container">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Kontak Kami
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">Tambah
                                Kontak</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Icon Kontak</th>
                                        <th>Nama Kontak</th>
                                        <th>Keterangan Kontak</th>
                                        <th>URL</th> <!-- Added URL column -->
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($kontak->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-warning">
                                                    Belum ada kontak.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($kontak as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td><img src="{{ asset('images/' . $item->icon_kontak) }}" alt="Icon"
                                                        width="30" height="auto"></td>
                                                <td>{{ $item->nama_kontak }}</td>
                                                <td>{{ $item->keterangan_kontak }}</td>
                                                <td><a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a>
                                                </td> <!-- Display URL -->
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
                        @foreach ($kontak as $item)
                            <div class="modal fade" id="showModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="showModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Kontak</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <!-- Icon Kontak -->
                                                <div class="form-group">
                                                    <label for="icon_kontak-show">Icon Kontak</label>
                                                    <div>
                                                        <!-- Display default image if icon_kontak is not set -->
                                                        <img src="{{ asset('images/' . ($item->icon_kontak ? $item->icon_kontak : 'default-icon.png')) }}"
                                                            alt="Icon" width="100" height="auto">
                                                    </div>
                                                </div>

                                                <!-- Nama Kontak -->
                                                <div class="form-group">
                                                    <label for="nama_kontak-show">Nama Kontak</label>
                                                    <input type="text" class="form-control" id="nama_kontak-show"
                                                        value="{{ $item->nama_kontak }}" readonly>
                                                </div>

                                                <!-- Keterangan Kontak -->
                                                <div class="form-group">
                                                    <label for="keterangan_kontak-show">Keterangan Kontak</label>
                                                    <input type="text" class="form-control" id="keterangan_kontak-show"
                                                        value="{{ $item->keterangan_kontak }}" readonly>
                                                </div>

                                                <!-- URL (if available) -->
                                                <div class="form-group">
                                                    <label for="url-show">URL</label>
                                                    @if ($item->url)
                                                        <a href="{{ $item->url }}" target="_blank"
                                                            class="form-control">{{ $item->url }}</a>
                                                    @else
                                                        <input type="text" class="form-control" value="No URL provided"
                                                            readonly>
                                                    @endif
                                                </div>

                                                <!-- Status -->
                                                <div class="form-group">
                                                    <label for="status-show">Status</label>
                                                    <input type="text" class="form-control" id="status-show"
                                                        value="{{ $item->status }}" readonly
                                                        style="background-color: {{ $item->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; 
                                                              color: {{ $item->status == 'Aktif' ? 'green' : 'red' }};">
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
                        @foreach ($kontak as $item)
                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kontak</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('kontak.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="icon_kontak-edit">Icon Kontak (Image)</label>
                                                    <input type="file" class="form-control" id="icon_kontak-edit"
                                                        name="icon_kontak" onchange="previewImageEdit(event)">
                                                    <img id="icon_kontak-preview-edit"
                                                        src="{{ asset('images/' . $item->icon_kontak) }}"
                                                        alt="Image Preview" style="max-width: 100px; margin-top: 10px;">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_kontak-edit">Nama Kontak</label>
                                                    <input type="text" class="form-control" id="nama_kontak-edit"
                                                        name="nama_kontak" value="{{ $item->nama_kontak }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan_kontak-edit">Keterangan Kontak</label>
                                                    <input type="text" class="form-control"
                                                        id="keterangan_kontak-edit" name="keterangan_kontak"
                                                        value="{{ $item->keterangan_kontak }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="url-edit">URL</label>
                                                    <input type="url" class="form-control" id="url-edit"
                                                        name="url" value="{{ $item->url }}"
                                                        placeholder="Masukkan URL">
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

                        <script>
                            function previewImageEdit(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('icon_kontak-preview-edit');
                                    output.src = reader.result;
                                    output.style.display = 'block';
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
                                        <h5 class="modal-title">Tambah Kontak</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('kontak.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="icon_kontak-create">Icon Kontak (Image)</label>
                                                <input type="file" class="form-control" id="icon_kontak-create"
                                                    name="icon_kontak" onchange="previewImage(event)">
                                                <img id="icon_kontak-preview" src="#" alt="Image Preview"
                                                    style="display: none; max-width: 100px; margin-top: 10px;">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_kontak-create">Nama Kontak</label>
                                                <input type="text" class="form-control" id="nama_kontak-create"
                                                    name="nama_kontak" placeholder="Masukkan nama kontak" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan_kontak-create">Keterangan Kontak</label>
                                                <input type="text" class="form-control" id="keterangan_kontak-create"
                                                    name="keterangan_kontak" placeholder="Masukkan keterangan kontak"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="url-create">URL</label>
                                                <input type="url" class="form-control" id="url-create"
                                                    name="url" placeholder="Masukkan URL">
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

                        <script>
                            function previewImage(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('icon_kontak-preview');
                                    output.src = reader.result;
                                    output.style.display = 'block';
                                };
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>


                        <!-- Delete Modal -->
                        @foreach ($kontak as $item)
                            <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Kontak</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this contact?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('kontak.destroy', $item->id) }}" method="POST">
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
