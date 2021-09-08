@extends('layout.v_template')
@section('title','Edit Guru')
@section('content')
<form action="/guru/update/{{ $guru->id_guru }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>NIP</label>
                    <input name="nip" class="form-control" value="{{ $guru->nip }}" readonly>
                    <div class="text-danger">
                        @error('nip')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Guru</label>
                    <input name="nama_guru" class="form-control" value="{{ $guru->nama_guru }}">
                    <div class="text-danger">
                        @error('nama_guru')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <input name="mapel" class="form-control" value="{{ $guru->mapel }}">
                    <div class="text-danger">
                        @error('mapel')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-sm 12">
                    <div class="col-sm-4">
                        <img src="{{ url('foto_guru/'.$guru->foto_guru) }}" width="150px">
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Ganti Foto Guru</label>
                            <input type="file" name="foto_guru" class="form-control">
                            <div class="text-danger">
                                @error('foto_guru')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="cal-sm 12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
