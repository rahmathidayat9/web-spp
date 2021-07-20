<!DOCTYPE html>
<html>
<head>
    <title>GENERATE PDF</title>
</head>
<body>
<br><br>
<center>
  <h2 style="font-family: sans-serif;">History Pembayaran SPP</h2>
</center>
<br>
<div style="float: left;">
  <b style="font-family: sans-serif;">Nama Siswa : {{ $pembayaran->siswa->nama_siswa }}</h3><br>
  <b style="font-family: sans-serif;">Kelas : {{ $pembayaran->siswa->kelas->nama_kelas }}</b><br>
  <b style="font-family: sans-serif;">Nisn : {{ $pembayaran->siswa->nisn }}</b><br>
  <b style="font-family: sans-serif;">Nis : {{ $pembayaran->siswa->nis }}</b><br>
</div>

<br><br><br><br><br>
<table style="" border="1" cellspacing="0" cellpadding="10" width="100%">
  <thead>
    <tr>
      <th scope="col" style="font-family: sans-serif;">Petugas</th>
      <th scope="col" style="font-family: sans-serif;">Untuk Tahun</th>
      <th scope="col" style="font-family: sans-serif;">Untuk Bulan</th>
      <th scope="col" style="font-family: sans-serif;">Jumlah Bayar</th>
      <th scope="col" style="font-family: sans-serif;">Kode Pembayaran</th>
      <th scope="col" style="font-family: sans-serif;">Tanggal Bayar</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="font-family: sans-serif;">{{ $pembayaran->petugas->nama_petugas }}</td>
      <td style="font-family: sans-serif;">{{ $pembayaran->tahun_bayar }}</td>
      <td style="font-family: sans-serif;">{{ $pembayaran->bulan_bayar }}</td>
      <td style="font-family: sans-serif;">{{ $pembayaran->jumlah_bayar }}</td>
      <td style="font-family: sans-serif;">{{ $pembayaran->kode_pembayaran }}</td>
      <td style="font-family: sans-serif;">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
    </tr>
  </tbody>
</table>
</body>
</html>