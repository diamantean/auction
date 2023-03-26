<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $data['title'] ?></h3>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <?= $data['title'] . ' (' . count($data['dataLaporan']) . ')' ?>
                    <a href="<?= BASE_URL ?>/laporan/cetak" class="btn btn-success" target="_blank">Print PDF <i data-feather="file-text"></i></a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>Name of Item</th>
                                <th>Bid Date</th>
                                <th>Starting Price</th>
                                <th>Final Price</th>
                                <th>Auction Winner</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['dataLaporan'] as $dl) : ?>
                                <tr>
                                    <td><?= $dl['nama_barang'] ?></td>
                                    <td><?= date('d F Y', strtotime($dl['tgl_lelang'])) ?></td>
                                    <td><?= $dl['harga_awal'] ?></td>
                                    <td><?= $dl['harga_akhir'] ?></td>
                                    <td><?= $dl['nama_lengkap'] ?></td>
                                    <td><?= $dl['telp'] ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>