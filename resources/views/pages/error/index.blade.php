@extends('layouts.base')
@section('title', 'ERROR 404')
@section('subTitle', 'ERROR 404')

@section('content')
    <div class="main-container">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 d-flex justify-content-between align-items-center">
                            ERROR 404
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createModal">Tambah
                                Data</button>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th> <!-- Centered -->
                                        <th>Text Error</th>
                                        <th class="text-center">Status</th> <!-- Centered -->
                                        <th class="text-center">Aksi</th> <!-- Centered -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($errors->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="alert alert-secondary">
                                                    Belum ada data.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($errors as $key => $error)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td> <!-- Centered -->
                                                <td>{{ $error->keterangan }}</td>
                                                <td class="text-center">
                                                    <span class="status-label"
                                                        style="background-color: {{ $error->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; 
                                                               color: {{ $error->status == 'Aktif' ? 'green' : 'red' }}; 
                                                               padding: 5px 10px; font-size: 12px;">
                                                        {{ $error->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#showModal-{{ $error->id }}">Show</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#editModal-{{ $error->id }}">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal-{{ $error->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Show Modal -->
                        @foreach ($errors as $error)
                            <div class="modal fade" id="showModal-{{ $error->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="showModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Error 404</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="footer-show">Text Error</label>
                                                    <input type="text" class="form-control" id="footer-show"
                                                        value="{{ $error->keterangan }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-show">Status</label>
                                                    <input type="text" class="form-control" id="status-show"
                                                        value="{{ $error->status }}" readonly
                                                        style="background-color: {{ $error->status == 'Aktif' ? '#d4edda' : '#f8d7da' }}; color: {{ $error->status == 'Aktif' ? 'green' : 'red' }};">
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
                        @foreach ($errors as $error)
                            <div class="modal fade" id="editModal-{{ $error->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Error 404</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('error.update', $error->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="footer-edit">Text Error</label>
                                                    <input type="text" class="form-control" id="footer-edit"
                                                        name="keterangan" value="{{ $error->keterangan }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status-edit">Status</label>
                                                    <select class="form-control" id="status-edit" name="status">
                                                        <option value="Aktif"
                                                            {{ $error->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                                        </option>
                                                        <option value="Nonaktif"
                                                            {{ $error->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
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
                                        <h5 class="modal-title">Tambah Error 404</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('error.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="footer-create">Text Error</label>
                                                <input type="text" class="form-control" id="footer-create"
                                                    name="keterangan" placeholder="Masukkan Text Error">
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
                        @foreach ($errors as $error)
                            <div class="modal fade" id="deleteModal-{{ $error->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Error 404</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this error?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('error.destroy', $error->id) }}" method="POST">
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
