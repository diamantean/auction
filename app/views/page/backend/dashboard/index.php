<?php
if (isset($_SESSION['user']['nama_petugas'])) {
    $nama = $_SESSION['user']['nama_petugas'];
} else {
    $nama = $_SESSION['user']['nama_lengkap'];
}
?>
<div class="main-content container-fluid">
    <div class="page-title">
        <h1>Welcome, <?= $nama ?></h1>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <?= $data['title'] ?>
                </h4>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['user']['level'])) { ?>
                    <h3>Dashboard</h3>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-12 col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h1 class="text-white"><?= count($data['dataBarang']) ?></h1>
                                    <h3 class="text-white">Items Data</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card bg-secondary">
                                <div class="card-body p-3">
                                    <h1 class="text-white"><?= count($data['dataLelang']) ?></h1>
                                    <h3 class="text-white">Item Auction</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card bg-success">
                                <div class="card-body p-3">
                                    <h1 class="text-white"><?= count($data['dataPetugas']) ?></h1>
                                    <h3 class="text-white">Operator Data</h3>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        <?php } else { ?>
            <h3>What are you looking for?</h1>
                <hr>
                <a href="<?= BASE_URL ?>/#lelang" class="btn btn-primary">Auction Catalog</a>
            <?php } ?>
        </div>
    </section>
</div>

