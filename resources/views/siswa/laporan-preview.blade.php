<!DOCTYPE html>
<html>
<head>
    <title>GENERATE PDF</title>
</head>
<body>
<br><br>
<center>
  <h2 style="font-family: sans-serif;">Laporan Pembayaran Spp</h2><br><br>
  <b style="font-family: sans-serif;">Nama Siswa : {{ $data_siswa->nama_siswa }}</b><br><br>
  <b style="font-family: sans-serif;">NISN : {{ $data_siswa->nisn }}</b><br><br>
  <b style="font-family: sans-serif;">Kelas : {{ $data_siswa->kelas->nama_kelas }}</b><br><br>
</center>
<br>
<b>Untuk Tahun : {{ request()->tahun_bayar }}</b><br><br>
<table style="" border="1" cellspacing="0" cellpadding="10" width="100%">
  <thead>
    <tr>
      <th style="font-family: sans-serif;">No</th>
      <th style="font-family: sans-serif;">Nama Siswa</th>
      <th style="font-family: sans-serif;">Nisn</th>
      <th style="font-family: sans-serif;">Tanggal Bayar</th>
      <th style="font-family: sans-serif;">Nama Petugas</th>
      <th style="font-family: sans-serif;">Untuk Bulan</th>
      <th style="font-family: sans-serif;">Untuk Tahun</th>
      <th style="font-family: sans-serif;">Nominal</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pembayaran as $row)
    <tr>
      <td style="font-family: sans-serif;">{{ $loop->iteration }}</td>
      <td style="font-family: sans-serif;">{{ $row->siswa->nama_siswa }}</td>
      <td style="font-family: sans-serif;">{{ $row->nisn }}</td>
      <td style="font-family: sans-serif;">{{ \Carbon\Carbon::parse($row->tanggal_bayar)->format('d-m-Y') }}</td>
      <td style="font-family: sans-serif;">{{ $row->petugas->nama_petugas }}</td>
      <td style="font-family: sans-serif;">{{ $row->bulan_bayar }}</td>
      <td style="font-family: sans-serif;">{{ $row->tahun_bayar }}</td>
      <td style="font-family: sans-serif;">{{ $row->jumlah_bayar }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>