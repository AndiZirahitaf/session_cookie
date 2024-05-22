<!-- Buatlah website yang menerapkan materi session, cookie, dan CRUD ( Create, Read, Update, Delete).  Ketentuan halaman yakni login, tabel data beserta button CRUD, dan button logout. Kriteria penilaian penerapan materi dan kreativitas tampilan website. Diperbolehkan menggunakan bootstrap sebagai framework UI. Berikut pembagian tema :

NIM ganjil tema pendataan obat di apotik
NIM genap tema pendataan produk supermarket

Kumpulkan link google drive dari zip hasil pengerjaan. -->

<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "apotek");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}


function tambah($data) {
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $jml_stok = htmlspecialchars($data["jml_stok"]);
	$tgl_kadaluwarsa = htmlspecialchars($data["tgl_kadaluwarsa"]);
	$harga = htmlspecialchars($data["harga"]);
    

	// upload gambar
	$gambar = upload();
	if( !$gambar ) {
		return false;
	}

	$query = "INSERT INTO obat
				VALUES
			  ('', '$nama', '$kategori', '$jml_stok', '$tgl_kadaluwarsa', '$harga', '$gambar')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function upload() {

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	echo "<script>
				alert('$error $tmpName $ukuranFile');
			  </script>";

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 1000000 ) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;
}




function hapus($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM obat WHERE id = $id");
	return mysqli_affected_rows($conn);
}


function ubah($data) {
	global $conn;

	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $jml_stok = htmlspecialchars($data["jml_stok"]);
	$tgl_kadaluwarsa = htmlspecialchars($data["tgl_kadaluwarsa"]);
	$harga = htmlspecialchars($data["harga"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	
	// cek apakah user pilih gambar baru atau tidak
	if( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}
	

	$query = "UPDATE obat SET
				nama = '$nama',
				kategori = '$kategori',
				jml_stok = '$jml_stok',
                tgl_kadaluwarsa = '$tgl_kadaluwarsa',
                harga = '$harga',
				gambar = '$gambar'
			  WHERE id = $id
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}