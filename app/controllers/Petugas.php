<?php

class Petugas extends Controller
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
        $data['dataPetugas'] = $this->model('M_petugas')->getDataPetugas();
        $data['title'] = 'Data Petugas';
        $data['dataTable'] = true;

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/petugas/index', $data);
        $this->view('layouts/backend/footer', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Data Petugas';

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/petugas/create', $data);
        $this->view('layouts/backend/footer');
    }

    public function store()
    {
        if (isset($_POST['submit'])) {
            $namaPetugas = stripslashes(strip_tags(htmlspecialchars($_POST['nama_petugas'], ENT_QUOTES)));
            $username = stripslashes(strip_tags(htmlspecialchars($_POST['username'], ENT_QUOTES)));
            $password = stripslashes(strip_tags(htmlspecialchars($_POST['password'], ENT_QUOTES)));
            $idLevel = stripslashes(strip_tags(htmlspecialchars($_POST['hak_akses'], ENT_QUOTES)));

            if (strlen($password) < 7) {
                $alert = [
                    'title' => 'Failed',
                    'text' => 'Password has to be more than 7 characters',
                    'icon' => 'error'
                ];

                $_SESSION['alert'] = $alert;

                header("location:" . BASE_URL . "/petugas/create");
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);

                $resultCek = $this->model('M_petugas')->cekPetugasByUsername(username: $username);

                if (!$resultCek) {
                    $this->model('M_petugas')->addPetugas(namaPetugas: $namaPetugas, username: $username, password: $password, idLevel: $idLevel);

                    $alert = [
                        'title' => 'Succeed',
                        'text' => 'Data added',
                        'icon' => 'success'
                    ];

                    $_SESSION['alert'] = $alert;

                    header("location:" . BASE_URL . "/petugas");
                } else {
                    $alert = [
                        'title' => 'Failed',
                        'text' => 'Username has been registered already',
                        'icon' => 'error'
                    ];

                    $_SESSION['alert'] = $alert;

                    header("location:" . BASE_URL . "/petugas/create");
                }
            }
        }
    }

    public function edit(int $id)
    {
        $data['title'] = 'Edit Data Petugas';
        $data['dataPetugas'] = $this->model('M_petugas')->getDataPetugasById(id: $id);

        if (!$data['dataPetugas']) {
            header("location:" . BASE_URL . "/petugas");
        }

        $this->view('layouts/backend/header', $data);
        $this->view('page/backend/petugas/edit', $data);
        $this->view('layouts/backend/footer');
    }

    public function update(int $id)
    {
        if (isset($_POST['submit'])) {
            $namaPetugas = stripslashes(strip_tags(htmlspecialchars($_POST['nama_petugas'], ENT_QUOTES)));
            $username = stripslashes(strip_tags(htmlspecialchars($_POST['username'], ENT_QUOTES)));
            $idLevel = stripslashes(strip_tags(htmlspecialchars($_POST['hak_akses'], ENT_QUOTES)));

            $resultCek = $this->model('M_petugas')->getDataPetugasById($id);

            if ($_SESSION['user']['username'] == $resultCek['username']) {
                if (!empty($_POST['password'])) {
                    $password = stripslashes(strip_tags(htmlspecialchars($_POST['password'], ENT_QUOTES)));
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $this->model('M_petugas')->updatePetugas(id: $id, namaPetugas: $namaPetugas, username: $username, password: $password, idLevel: $idLevel);

                    $alert = [
                        'title' => 'Succeed',
                        'text' => 'Data updated',
                        'icon' => 'success',
                        'href' => BASE_URL . '/petugas'
                    ];

                    $_SESSION['alert'] = $alert;

                    header("location:" . BASE_URL . "/petugas");
                } else {
                    $this->model('M_petugas')->updatePetugas(id: $id, namaPetugas: $namaPetugas, username: $username, password: null, idLevel: $idLevel);

                    $alert = [
                        'title' => 'Succeed',
                        'text' => 'Data updated',
                        'icon' => 'success',
                        'href' => BASE_URL . '/petugas'
                    ];

                    $_SESSION['alert'] = $alert;

                    header("location:" . BASE_URL . "/petugas");
                }
            } else {
                if ($username == $resultCek['username']) {
                    if (!empty($_POST['password'])) {
                        $password = stripslashes(strip_tags(htmlspecialchars($_POST['password'], ENT_QUOTES)));
                        $password = password_hash($password, PASSWORD_DEFAULT);

                        $this->model('M_petugas')->updatePetugas(id: $id, namaPetugas: $namaPetugas, username: $username, password: $password, idLevel: $idLevel);

                        $alert = [
                            'title' => 'Succeed',
                            'text' => 'Data updated',
                            'icon' => 'success',
                            'href' => BASE_URL . '/petugas'
                        ];

                        $_SESSION['alert'] = $alert;

                        header("location:" . BASE_URL . "/petugas");
                    } else {
                        $this->model('M_petugas')->updatePetugas(id: $id, namaPetugas: $namaPetugas, username: $username, password: null, idLevel: $idLevel);

                        $alert = [
                            'title' => 'Succeed',
                            'text' => 'Data updated',
                            'icon' => 'success',
                            'href' => BASE_URL . '/petugas'
                        ];

                        $_SESSION['alert'] = $alert;

                        header("location:" . BASE_URL . "/petugas");
                    }
                } else {

                    $cekUsername = $this->model('M_petugas')->cekPetugasByUsername(username: $username);

                    if ($cekUsername) {
                        $alert = [
                            'title' => 'Failed',
                            'text' => 'Username has been registered already',
                            'icon' => 'error'
                        ];

                        $_SESSION['alert'] = $alert;

                        echo '<script>history.back()</script>';
                    } else {
                        if (!empty($_POST['password'])) {
                            $password = stripslashes(strip_tags(htmlspecialchars($_POST['password'], ENT_QUOTES)));
                            $password = password_hash($password, PASSWORD_DEFAULT);

                            $this->model('M_petugas')->updatePetugas(id: $id, namaPetugas: $namaPetugas, username: $username, password: $password, idLevel: $idLevel);

                            $alert = [
                                'title' => 'Succeed',
                                'text' => 'Data updated',
                                'icon' => 'success',
                                'href' => BASE_URL . '/petugas'
                            ];

                            $_SESSION['alert'] = $alert;

                            header("location:" . BASE_URL . "/petugas");
                        } else {
                            $this->model('M_petugas')->updatePetugas(id: $id, namaPetugas: $namaPetugas, username: $username, password: null, idLevel: $idLevel);

                            $alert = [
                                'title' => 'Succeed',
                                'text' => 'Data updated',
                                'icon' => 'success',
                                'href' => BASE_URL . '/petugas'
                            ];

                            $_SESSION['alert'] = $alert;

                            header("location:" . BASE_URL . "/petugas");
                        }
                    }
                }
            }
        }
    }

    public function delete()
    {
        $id = stripslashes(strip_tags(htmlspecialchars($_POST['id'], ENT_QUOTES)));

        $this->model('M_petugas')->deletePetugas(id: $id);

        $alert = [
            'title' => 'Succeed',
            'text' => 'Data deleted',
            'icon' => 'success',
            'href' => BASE_URL . '/petugas'
        ];

        $_SESSION['alert'] = $alert;

        header("location:" . BASE_URL . "/petugas");
    }
}
