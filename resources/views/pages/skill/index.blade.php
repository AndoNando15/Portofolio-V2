@extends('layouts.base')
@section('title', 'Skill')
@section('subTitle', 'Skill')

@section('content')
    <div class="main-container">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            Judul
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">Tambah
                                Data</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Icon Skill</th>
                                        <th>Nama Skill</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($skill->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="alert alert-warning">
                                                    Belum ada data skill.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($skill as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img src="{{ asset('images/icons/' . $item->icon_skill) }}"
                                                        alt="Icon Skill" width="50" height="auto"> </td>


                                                <td>{{ $item->nama_skill }}</td>
                                                <td>
                                                    <span class="status-label"
                                                        style="background-color: {{ $item->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; 
                                                               color: {{ $item->status == 'Aktif' ? 'green' : 'red' }}; padding: 5px 10px; font-size: 12px;">
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


                            <!-- Show Modal -->
                            @foreach ($skill as $item)
                                <div class="modal fade" id="showModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="showModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Skill</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="icon-skill-show">Icon Skill</label>
                                                        <img src="{{ $item->icon_skill }}" alt="Icon Skill" width="50"
                                                            height="50">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama-skill-show">Nama Skill</label>
                                                        <input type="text" class="form-control" id="nama-skill-show"
                                                            value="{{ $item->nama_skill }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="status-show">Status</label>
                                                        <input type="text" class="form-control" id="status-show"
                                                            value="{{ $item->status }}" readonly
                                                            style="background-color: {{ $item->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; color: {{ $item->status == 'Aktif' ? 'green' : 'red' }};">
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
                            @foreach ($skill as $item)
                                <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Skill</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('skill.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="icon-skill-edit">Icon Skill</label>
                                                        <input type="file" class="form-control" id="icon-skill-edit"
                                                            name="icon_skill" accept="image/*"
                                                            onchange="previewImageEdit(event)">
                                                        <img id="preview-image-edit"
                                                            src="{{ asset('storage/icons/' . $item->icon_skill) }}"
                                                            alt="Image Preview" class="mt-3"
                                                            style="max-width: 100%;" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama-skill-edit">Nama Skill</label>
                                                        <input type="text" class="form-control" id="nama-skill-edit"
                                                            name="nama_skill" value="{{ $item->nama_skill }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="status-edit">Status</label>
                                                        <select class="form-control" id="status-edit" name="status">
                                                            <option value="Aktif"
                                                                {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                                            </option>
                                                            <option value="Nonaktif"
                                                                {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>
                                                                Nonaktif</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Simpan
                                                        Perubahan</button>
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
                                        var output = document.getElementById('preview-image-edit');
                                        output.src = reader.result;
                                    }
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
                                            <h5 class="modal-title">Tambah Skill</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('skill.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="icon-skill-create">Icon Skill</label>
                                                    <input type="file" class="form-control" id="icon-skill-create"
                                                        name="icon_skill" accept="image/*"
                                                        onchange="previewImage(event)">
                                                    <img id="preview-image" src="#" alt="Image Preview"
                                                        class="mt-3" style="display: none; max-width: 100%;" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama-skill-create">Nama Skill</label>
                                                    <input type="text" class="form-control" id="nama-skill-create"
                                                        name="nama_skill" placeholder="Masukkan nama skill">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-create">Status</label>
                                                    <select class="form-control" id="status-create" name="status">
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

                            <script>
                                function previewImage(event) {
                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var output = document.getElementById('preview-image');
                                        output.src = reader.result;
                                        output.style.display = 'block';
                                    }
                                    reader.readAsDataURL(event.target.files[0]);
                                }
                            </script>



                            <!-- Delete Modal -->
                            @foreach ($skill as $item)
                                <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Skill</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this skill?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('skill.destroy', $item->id) }}" method="POST">
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
        </div>
        <!-- Row end -->

    </div>
@endsection
