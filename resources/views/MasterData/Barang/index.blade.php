<!-- Main navbar -->
@push('css')
<script src="{{asset('template/assets/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('template/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('template/assets/js/vendor/tables/datatables/extensions/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('template/assets/js/vendor/tables/datatables/extensions/pdfmake/vfs_fonts.min.js')}}"></script>
<script src="{{asset('template/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
<script src="{{asset('template/assets/demo/pages/datatables_extension_buttons_html5.js')}}"></script>


@endpush
@include('layouts.navbar')

<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">

    @include('layouts.sidebar')
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
           @include('layouts.page_header')
            <!-- /page header -->





<!-- Content area -->
<div class="content">
    <button type="button" class="btn btn-primary btn-labeled btn-labeled-start mb-2">
        <span class="btn-labeled-icon bg-black bg-opacity-20">
            <i class="icon-database-add"></i>
        </span>
        Tambah
    </button>
    <!-- Basic initialization -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Data Barang</h5>
        </div>

        <table class="table datatable-button-html5-basic">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Barang Kode</th>
                    <th>Qr Code</th>
                    <th>Kategori</th>
                    <th>Jenis Barang</th>
                    <th>Satuan</th>
                    <th>Stok Tersedia</th>
                    <th>Stok Dipinjam</th>
                    <th>Stok Maintenen</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $key => $barang)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><img src="{{asset('storage/'.$barang->barang_gambar)}}" class="" alt=""></td>
                    <td>{{$barang->barang_nama}}</td>
                    <td>{{$barang->barang_kode}}</td>
                    <td>
                        @php
                            $qrCodeSvg = asset('storage/qr_code/' . $barang->barang_kode . '.svg');
                            $qrCodeJpg = asset('storage/qr_code/' . $barang->barang_kode . '.jpg');
                            $qrCodePng = asset('storage/qr_code/' . $barang->barang_kode . '.png');
                        @endphp

                        @if (file_exists(public_path('storage/qr_code/' . $barang->barang_kode . '.svg')))
                            <img src="{{ $qrCodeSvg }}" alt="QR Code SVG">
                        @elseif (file_exists(public_path('storage/qr_code/' . $barang->barang_kode . '.png')))
                            <img src="{{ $qrCodePng }}" alt="QR Code PNG">
                        @elseif (file_exists(public_path('storage/qr_code/' . $barang->barang_kode . '.jpg')))
                            <img src="{{ $qrCodeJpg }}" alt="QR Code JPG">
                        @else
                            <span>Tidak ada QR Code</span>
                        @endif
                    </td>
                    <td>none</td>
                    <td>{{ $barang->jenisBarang->name ?? '-' }}</td>
                    <td>{{ $barang->satuan->name ?? '-' }}</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                    <td>$85,600</td>
                    <td></td>
                    <td>
                        <div class="d-inline-flex">
                            <a href="#" class="text-primary">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-danger mx-2">
                                <i class="ph-trash"></i>
                            </a>
                            <a href="#" class="text-teal">
                                <i class="ph-gear"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>
    </div>
    <!-- /basic initialization -->






</div>
<!-- /content area -->


            <!-- Content area -->




            @include('layouts.footer')


        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>

<!-- /page content -->


<!-- Notifications -->
@include('layouts.components.notifications')

<!-- /notifications -->


<!-- Demo config -->
@include('layouts.components.demo_config')

<!-- /demo config -->

</body>

</html>
