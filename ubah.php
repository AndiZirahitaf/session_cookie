<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: login.php");
	exit;
}

require 'conn.php';

// ambil data di URL
$id = $_GET["id"];

$obat = query("SELECT * FROM obat WHERE id = $id")[0];


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["simpan"]) ) {
	
	// cek apakah data berhasil diubah atau tidak
	if( ubah($_POST) > 0 ) {
		echo "
			<script>
				alert('data berhasil diubah!');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal diubah!');
				document.location.href = 'index.php';
			</script>
		";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Apotek Sehat</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: 'DM Sans', sans-serif;
        /* background-color: #ecc6ff; */
        opacity: 1;

        /* background: linear-gradient(135deg, #fefcff55 25%, transparent 25%) -12px 0/ 24px 24px, linear-gradient(225deg, #fefcff 25%, transparent 25%) -12px 0/ 24px 24px, linear-gradient(315deg, #fefcff55 25%, transparent 25%) 0px 0/ 24px 24px, linear-gradient(45deg, #fefcff 25%, #ecc6ff 25%) 0px 0/ 24px 24px; */
    }

    body {
        --s: 80px;
        /* the size */
        --c: #c4ffc8;

        --_s: calc(2*var(--s)) calc(2*var(--s));
        --_g: 35.36% 35.36% at;
        --_c: #0000 66%, #a3f0a9 68% 70%, #0000 72%;
        background:
            radial-gradient(var(--_g) 100% 25%, var(--_c)) var(--s) var(--s)/var(--_s),
            radial-gradient(var(--_g) 0 75%, var(--_c)) var(--s) var(--s)/var(--_s),
            radial-gradient(var(--_g) 100% 25%, var(--_c)) 0 0/var(--_s),
            radial-gradient(var(--_g) 0 75%, var(--_c)) 0 0/var(--_s),
            repeating-conic-gradient(var(--c) 0 25%, #0000 0 50%) 0 0/var(--_s),
            radial-gradient(var(--_c)) 0 calc(var(--s)/2)/var(--s) var(--s) var(--c);
    }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">


        <div class="container  ">
            <h1 class="text-center fw-bold mb-4">Edit</h1>

            <div class="card p-3 col-4 mx-auto shadow-lg rounded">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $obat["id"]; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $obat["gambar"]; ?>">
                    <div class="modal-body">


                        <div class="mb-3">

                            <label for="nama" class="form-label">Nama Obat</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $obat["nama"];?>"
                                required>
                        </div>

                        <div class="mb-3">

                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control"
                                value="<?= $obat["kategori"];?>" required>
                        </div>

                        <div class="mb-3">

                            <label for="jml_stok" class="form-label">Stok</label>
                            <input type="number" name="jml_stok" id="jml_stok" class="form-control"
                                value="<?= $obat["jml_stok"];?>" required>
                        </div>

                        <div class="mb-3">

                            <label for="tgl_kadaluwarsa" class="form-label">Tgl Kadaluwarsa</label>
                            <input type="text" name="tgl_kadaluwarsa" id="tgl_kadaluwarsa" class="form-control"
                                value="<?= $obat["tgl_kadaluwarsa"];?>" required>
                        </div>

                        <div class="mb-3">

                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control"
                                value="<?= $obat["harga"];?>" required>
                        </div>

                        <div class="mb-3">

                            <label for="gambar" class="form-label">Gambar</label>
                            <img src="img/<?= $obat['gambar']; ?>" width="40"> <br>
                            <input type="file" name="gambar" id="gambar" class="form-control">
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="submit" class="btn btn-primary" name="simpan">Ubah Data</button>
                    </div>
                </form>
            </div>

        </div>



</body>

</html>