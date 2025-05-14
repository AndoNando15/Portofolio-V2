@extends('layouts.base')
@section('title', 'Proyek')
@section('subTitle', 'Proyek')

@section('content')
    <div class="main-container">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Daftar Proyek
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">Tambah
                                Data</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Thumbnail Proyek</th>
                                        <th>Judul Proyek</th>
                                        <th>Jenis Proyek</th>
                                        <th>Teknologi</th>
                                        <th>Detail Proyek</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($proyek->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="alert alert-warning">Belum ada data.</div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($proyek as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img src="{{ $item->thumbnail_proyek }}" class="img-thumbnail"
                                                        alt="Thumbnail" width="100"></td>
                                                <td>{{ $item->judul_proyek }}</td>
                                                <td>{{ $item->jenis_proyek }}</td>
                                                <td>{{ $item->teknologi }}</td>
                                                <td>{!! $item->detail_proyek !!}</td>
                                                <td>
                                                    <span class="status-label"
                                                        style="background-color: {{ $item->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; color: {{ $item->status == 'Aktif' ? 'green' : 'red' }};padding: 5px 10px; font-size: 12px;">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td>
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

                        <!-- Create Modal -->
                        <!-- Create Modal -->
                        <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
                            aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Proyek</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('proyek.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="thumbnail_proyek">Thumbnail Proyek</label>
                                                <input type="file" class="form-control-file" id="thumbnail_proyek"
                                                    name="thumbnail_proyek" accept="image/*" required
                                                    onchange="previewImage(event)">
                                                <img id="thumbnail-preview" src="" alt="Preview"
                                                    style="max-width: 100px; display: none;">
                                            </div>

                                            <div class="form-group">
                                                <label for="judul_proyek">Judul Proyek</label>
                                                <input type="text" class="form-control" id="judul_proyek"
                                                    name="judul_proyek" placeholder="Masukkan judul proyek" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_proyek">Jenis Proyek</label>
                                                <input type="text" class="form-control" id="jenis_proyek"
                                                    name="jenis_proyek" placeholder="Masukkan jenis proyek" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="teknologi">Teknologi</label>
                                                <select class="form-control" id="teknologi" name="teknologi[]"
                                                    multiple="multiple" required>
                                                    @foreach ($tech as $item)
                                                        <option value="{{ $item->id }}">{{ $item->tech }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="detail_proyek">Detail Proyek</label>
                                                <textarea class="form-control" id="detail_proyek" name="detail_proyek" placeholder="Masukkan detail proyek" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="gambar">Tambah Gambar Proyek</label>
                                                <input type="file" class="form-control-file" id="gambar"
                                                    name="gambar[]" accept="image/*" multiple required>
                                                <small>Upload multiple images if necessary</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Nonaktif">Nonaktif</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Edit Modal -->
                        @foreach ($proyek as $item)
                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Proyek</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('proyek.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <!-- Thumbnail Proyek -->
                                                <div class="form-group">
                                                    <label for="thumbnail_proyek">Thumbnail Proyek</label>
                                                    <input type="file" class="form-control-file" id="thumbnail_proyek"
                                                        name="thumbnail_proyek" accept="image/*"
                                                        onchange="previewImageEdit(event)">
                                                    <img id="thumbnail-preview-edit"
                                                        src="{{ asset($item->thumbnail_proyek) }}" alt="Thumbnail"
                                                        style="max-width: 100px; display: block;">
                                                </div>

                                                <!-- Judul Proyek -->
                                                <div class="form-group">
                                                    <label for="judul_proyek">Judul Proyek</label>
                                                    <input type="text" class="form-control" id="judul_proyek"
                                                        name="judul_proyek" value="{{ $item->judul_proyek }}" required>
                                                </div>

                                                <!-- Jenis Proyek -->
                                                <div class="form-group">
                                                    <label for="jenis_proyek">Jenis Proyek</label>
                                                    <input type="text" class="form-control" id="jenis_proyek"
                                                        name="jenis_proyek" value="{{ $item->jenis_proyek }}" required>
                                                </div>

                                                <!-- Teknologi -->
                                                <div class="form-group">
                                                    <label for="teknologi">Teknologi</label>
                                                    <select class="form-control" id="teknologi" name="teknologi[]"
                                                        multiple="multiple" required>
                                                        @foreach ($tech as $techItem)
                                                            <option value="{{ $techItem->id }}"
                                                                {{ in_array($techItem->id, explode(',', $item->teknologi)) ? 'selected' : '' }}>
                                                                {{ $techItem->tech }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Detail Proyek -->
                                                <div class="form-group">
                                                    <label for="detail_proyek">Detail Proyek</label>
                                                    <textarea class="form-control" id="detail_proyek-edit-{{ $item->id }}" name="detail_proyek" required>{{ $item->detail_proyek }}</textarea>
                                                </div>

                                                <!-- Status -->
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="Aktif"
                                                            {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Nonaktif"
                                                            {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
                                                        </option>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach




                        <!-- Show Modal -->
                        <!-- Show Modal -->
                        @foreach ($proyek as $item)
                            <div class="modal fade" id="showModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="showModalLabel-{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Proyek</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Judul Proyek -->
                                            <div class="form-group">
                                                <label for="judul_proyek">Judul Proyek:</label>
                                                <p>{{ $item->judul_proyek }}</p>
                                            </div>

                                            <!-- Jenis Proyek -->
                                            <div class="form-group">
                                                <label for="jenis_proyek">Jenis Proyek:</label>
                                                <p>{{ $item->jenis_proyek }}</p>
                                            </div>

                                            <!-- Teknologi -->
                                            <div class="form-group">
                                                <label for="teknologi">Teknologi:</label>
                                                <p>{{ $item->teknologi }}</p>
                                            </div>

                                            <!-- Detail Proyek -->
                                            <div class="form-group">
                                                <label for="detail_proyek">Detail Proyek:</label>
                                                <p>{{ $item->detail_proyek }}</p>
                                            </div>

                                            <!-- Status -->
                                            <div class="form-group">
                                                <label for="status">Status:</label>
                                                <p>{{ $item->status }}</p>
                                            </div>

                                            <!-- Gambar Proyek (Moved to the bottom) -->
                                            <!-- Gambar Proyek -->
                                            <div class="form-group">
                                                <label for="gambar_proyek">Gambar Proyek:</label>
                                                @foreach ($item->gambarProyek as $index => $gambar)
                                                    <div class="form-group">
                                                        <label>Gambar {{ $index + 1 }}:</label>
                                                        <!-- Display image number -->
                                                        <img src="{{ asset('images/' . $gambar->gambar_path) }}"
                                                            alt="Gambar Path" width="100" height="auto">
                                                    </div>
                                                @endforeach
                                            </div>

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
                        @foreach ($proyek as $item)
                            <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Proyek</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this project?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('proyek.destroy', $item->id) }}" method="POST">
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        // Preview Image Function for Create Modal
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('thumbnail-preview');
                output.src = reader.result;
                output.style.display = 'block'; // Show the preview image
            }
            reader.readAsDataURL(event.target.files[0]); // Read the file
        }

        // Preview Image Function for Edit Modal
        function previewImageEdit(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('thumbnail-preview-edit');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]); // Read the file
        }
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        // Initialize CKEditor for 'detail_proyek' textarea in the Create Modal
        ClassicEditor
            .create(document.querySelector('#detail_proyek'))
            .catch(error => {
                console.error(error);
            });

        // Initialize CKEditor for each 'detail_proyek' textarea in the Edit Modals
        @foreach ($proyek as $item)
            ClassicEditor
                .create(document.querySelector('#detail_proyek-edit-{{ $item->id }}'))
                .catch(error => {
                    console.error(error);
                });
        @endforeach
    </script>

@endsection
