<?php 
session_start();
if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'true') {
    $_SESSION['login'] = true;
}
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}
require 'conn.php';
$obat = query("SELECT * FROM obat");


if( isset($_POST["simpan"]) ) {
	
	// cek apakah data berhasil di tambahkan atau tidak
	if( tambah($_POST) > 0 ) {
		echo "
			<script>
				alert('data berhasil simpan!');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal simpan!');
				document.location.href = 'index.php';
			</script>
		";
	}
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Daftar Obat</title>
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


    .shadow-lg {
        box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);
    }

    .title {
        font-size: 50px;
    }
    </style>

</head>

<body>

    <div class="my-5">
        <div class="container ">
            <div class="d-flex justify-content-between">
                <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah
                    Data Obat</a>
                <a href="logout.php" type="button" class="btn btn-danger">Logout</a>
            </div>
            <h1 class="text-center fw-bold title"> Apotek Sehat</h1>


            <br>


            <!-- Modal Tambah -->
            <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalTambahLabel">Tambah Data Obat</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">


                                <div class="mb-3">

                                    <label for="nama" class="form-label">Nama Obat</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>

                                <div class="mb-3">

                                    <label for="kategori" class="form-label">Kategori</label>
                                    <input type="text" name="kategori" id="kategori" class="form-control" required>
                                </div>

                                <div class="mb-3">

                                    <label for="jml_stok" class="form-label">Stok</label>
                                    <input type="number" name="jml_stok" id="jml_stok" class="form-control" required>
                                </div>

                                <div class="mb-3">

                                    <label for="tgl_kadaluwarsa" class="form-label">Tgl Kadaluwarsa</label>
                                    <input type="text" name="tgl_kadaluwarsa" id="tgl_kadaluwarsa" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">

                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" required>
                                </div>

                                <div class="mb-3">

                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control">
                                </div>
                            </div>
                            <div class=" modal-footer">
                                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 justify-content-center">

                <div class="card m-2 shadow-lg mb-5 rounded">
                    <div class="card-header text-white bg-success ">
                        Daftar Obat
                    </div>
                    <div class="card-body">

                        <table class="table table-striped" id="mhs">

                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="text-center">Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th class="text-start">Stok</th>
                                    <th class="text-start">Kadaluwarsa</th>
                                    <th class="text-start">Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach( $obat as $row ) : ?>
                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center"><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
                                    <td><?= $row["nama"]; ?></td>
                                    <td><?= $row["kategori"]; ?></td>
                                    <td class="text-start"><?= $row["jml_stok"]; ?></td>
                                    <td class="text-start"><?= $row["tgl_kadaluwarsa"]; ?></td>
                                    <td class="text-start"><?= $row["harga"]; ?></td>
                                    <td>
                                        <a href="ubah.php?id=<?= $row["id"];?>" class="btn btn-warning">
                                            Edit
                                        </a>

                                        <a href="hapus.php?id=<?= $row["id"];?>"
                                            onclick="return confirm('Apakah Anda Yakin?');" class="btn btn-danger">
                                            Delete
                                        </a>
                                    </td>

                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
    <script>
    $(document).ready(function() {
        $('#mhs').dataTable({
            "pageLength": 5
        });
    });
    </script>

</body>

</html>