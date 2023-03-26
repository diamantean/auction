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
                    <?= $data['title'] . ' (' . count($data['dataLelang']) . ')' ?>
                    <a href="<?= BASE_URL ?>/lelang/create" class="btn btn-primary">Add <i data-feather="plus"></i></a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>Name of Item</th>
                                <th>Start Date</th>
                                <th>Starting Price</th>
                                <th>Final Price</th>
                                <th>Winning Bidder</th>
                                <th>Operator</th>
                                <th>Auction Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['dataLelang'] as $dl) : ?>
                                <tr>
                                    <td><?= $dl['nama_barang'] ?></td>
                                    <td><?= date('d F Y', strtotime($dl['tgl_lelang'])) ?></td>
                                    <td><?= $dl['harga_awal'] ?></td>
                                    <td><?= $dl['harga_akhir'] ?? 'Not Yet' ?></td>
                                    <td><?= $dl['nama_lengkap'] ?? 'Not Yet' ?></td>
                                    <td><?= $dl['nama_petugas'] ?></td>
                                    <td><?= ucwords($dl['status']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/lelang/show/<?= $dl['id_lelang'] ?>" class="btn btn-success"><i data-feather="eye"></i></a>
                                        <a href="<?= BASE_URL ?>/lelang/edit/<?= $dl['id_lelang'] ?>" class="btn btn-warning"><i data-feather="edit"></i></a>
                                        <button class="btn btn-danger delete-confirm" data-action="<?= BASE_URL ?>/lelang/delete" data-id="<?= $dl['id_lelang'] ?>"><i data-feather="trash"></i></button>
                                        </form>
                                    </td>
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