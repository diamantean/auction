<?php

class Lelang extends Controller
{

    public function __construct()
    {
        if (empty($_SESSION['user'])) {
            header('location:' . BASE_URL . '/login');
        } else if (empty($_SESSION['user']['level'])) {
            header('location:' . BASE_URL . '/dashboard');
        }
    }

    public function index()
    {
        $data['dataLelang'] = $this->model('M_lelang')->getDataLelang();
        $data['title'] = 'Bid Item';
        $data['dataTable'] = true;

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/lelang/index', $data);
        $this->view('layouts/backend/footer', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Auction Data';
        $data['dataBarang'] = $this->model('M_barang')->getDataBarangBelumLelang();

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/lelang/create', $data);
        $this->view('layouts/backend/footer');
    }

    public function store()
    {
        if (isset($_POST['submit'])) {
            $idBarang = stripslashes(strip_tags(htmlspecialchars($_POST['barang'], ENT_QUOTES)));
            $tgl = stripslashes(strip_tags(htmlspecialchars($_POST['tanggal'], ENT_QUOTES)));
            $status = stripslashes(strip_tags(htmlspecialchars($_POST['status_lelang'], ENT_QUOTES)));

            $this->model('M_lelang')->addLelang(idBarang: $idBarang, tgl: $tgl, idPetugas: $_SESSION['user']['id_petugas'], status: $status);

            $alert = [
                'title' => 'Succeed',
                'text' => 'Item added',
                'icon' => 'success',
                'href' => BASE_URL . '/lelang'
            ];

            $_SESSION['alert'] = $alert;

            header("location:" . BASE_URL . "/lelang");
        }
    }

    public function show(int $id = null)
    {
        if (is_null($id)) {
            header("location:" . BASE_URL . "/lelang");
        }

        $data['title'] = 'Bid Detail';
        $data['dataHistoryLelang'] = $this->model('M_lelang')->getDataHistoryLelang(id: $id);
        $data['dataTable'] = true;

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/lelang/show', $data);
        $this->view('layouts/backend/footer', $data);
    }

    public function edit(int $id)
    {
        $data['title'] = 'Edit Bid Data';
        $data['dataLelang'] = $this->model('M_lelang')->getDataLelangById(id: $id);
        $data['dataBarang'] = $this->model('M_barang')->getDataBarang();

        if (!$data['dataLelang']) {
            header("location:" . BASE_URL . "/lelang");
        }

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/lelang/edit', $data);
        $this->view('layouts/backend/footer');
    }

    public function update(int $id)
    {
        if (isset($_POST['submit'])) {
            $idBarang = stripslashes(strip_tags(htmlspecialchars($_POST['barang'], ENT_QUOTES)));
            $tgl = stripslashes(strip_tags(htmlspecialchars($_POST['tanggal'], ENT_QUOTES)));
            $status = stripslashes(strip_tags(htmlspecialchars($_POST['status_lelang'], ENT_QUOTES)));

            $this->model('M_lelang')->updateLelang(id: $id, idBarang: $idBarang, tgl: $tgl, status: $status);

            if ($status == 'ditutup') {
                $data = $this->model('M_history_lelang')->getHargaTertinggi(id: $id);

                if ($data) {
                    $this->model('M_penawaran')->addPenawaran(idLelang: $id, idUser: $data['id_user'], hargaAkhir: $data['penawaran_harga']);
                }
            }

            $alert = [
                'title' => 'Succeed',
                'text' => 'Item updated',
                'icon' => 'success',
                'href' => BASE_URL . '/lelang'
            ];

            $_SESSION['alert'] = $alert;

            header("location:" . BASE_URL . "/lelang");
        }
    }

    public function delete()
    {
        $id = stripslashes(strip_tags(htmlspecialchars($_POST['id'], ENT_QUOTES)));

        $this->model('M_lelang')->deleteLelang(id: $id);

        $alert = [
            'title' => 'Succeed',
            'text' => 'Item deleted',
            'icon' => 'success',
            'href' => BASE_URL . '/lelang'
        ];

        $_SESSION['alert'] = $alert;

        header("location:" . BASE_URL . "/lelang");
    }
}
