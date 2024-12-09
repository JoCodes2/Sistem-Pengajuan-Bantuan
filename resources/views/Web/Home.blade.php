@extends('Layouts.UiWeb')
@section('content')
    <section class="home" id="home">
      <div class="container pt-5 mt-5" data-aos="zoom-in">
        <div class="row pt-2 justify-content-center">
          <div class="col-md-5 d-flex justify-content-center align-items-center">
            <div class="bg-home ">
              <img src="{{ asset('Image/home2.png') }}" class="img-fluid img" alt="">
            </div>
          </div>
          <div class="col-md-5 d-flex flex-column justify-content-center align-items-start">
            <p class="text-hai font-popins">Hallo 👋
            </p>
            <h1 class="title-home font-kanit sky">Selamat Datang di Sistem Informasi Pengaduan Aplikasi SRIKANDI
            </h1>
            <p class="intro-junior font-popins ">
                Aplikasi ini dibuat untuk melaporkan pengaduan tentang kekurangan atau kendala dalam menggunakan aplikasi SRIKANDI,
                 yang dimana aplikasi SRIKANDI sampai saat ini masih dalam proses pengembangan
            </p>
        </div>
      </div>
    </section>
    <section class="form-pengajuan">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-10">
                    <div class="row d-flex justify-content-center align-items-center py-2">
                        <h1 class="font-kanit sky text-center" data-aos="zoom-in">Silahkan mengisi Form dibawah untuk menjelaskan kendala saat menggunakan Aplikasi SRIKANDI
                        </h1>
                    </div>
                    <div class="card rounded-5" data-aos="zoom-in">
                        <div class="card-header">
                            <h2 class="font-kanit sky " id="pendudukModalLabel"><i class="fas fa-file-alt pr-5 pr-2"></i>Form Pengaduan</h2>
                        </div>
                        <div class="card-body">
                            <form id="upsertData" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_category_complaint">Kategori Pengaduan</label>
                                            <select name="id_category_complaint" id="id_category_complaint" class="form-control">
                                                <option value="" selected disabled>--pilih--</option>
                                            </select>
                                            <small id="id_category_complaint-error" class="text-danger"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="description_complaint">Deskripsi Pengaduan</label>
                                            <textarea class="form-control"name="description_complaint" id="description_complaint" style="display: none;"></textarea>
                                            <div id="summernote"></div>
                                            <small id="description_complaint-error" class="text-danger"></small>
                                        </div>
                                        <div class="form-group fill">
                                            <label for="image_complaint">Upload File (Jika Ada)</label>
                                            <input type="file" class="form-control" name="image_complaint" id="image_complaint" >
                                            <span id="image_complaint_filename" class="text-muted"></span>
                                            <small id="image_complaint-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                         <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn-cencel rounded-5 mr-2 px-3 py-1" id="btnBatal">Batal</button>
                            <button type="button" class="btn-home px-3 py-1 font-popins rounded-5" id="btnSimpan">Kirim Pengaduan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')


@endsection
