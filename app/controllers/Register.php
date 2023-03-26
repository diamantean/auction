<?php

class Register extends Controller
{

    public function __construct()
    {
        if (!empty($_SESSION['user'])) {
            header('location:' . BASE_URL . '/dashboard');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar';

        if (isset($_POST['submit'])) {
            $namaLengkap = stripslashes(strip_tags(htmlspecialchars($_POST['nama_lengkap'], ENT_QUOTES)));
            $username = stripslashes(strip_tags(htmlspecialchars($_POST['username'], ENT_QUOTES)));
            $password = stripslashes(strip_tags(htmlspecialchars($_POST['password'], ENT_QUOTES)));
            $noTelepon = stripslashes(strip_tags(htmlspecialchars($_POST['no_telepon'], ENT_QUOTES)));

            if (!empty($namaLengkap) && !empty($username) && !empty($password && !empty($noTelepon))) {
                if (strlen($password) < 7) {
                    $data['error'] = true;
                    $data['message'] = "Password has to be more than 7 characters";
                } else {
                    $resultCek = $this->model('M_user')->cekUser(username: $username);

                    if (!$resultCek) {
                        $this->model('M_user')->registerUser(namaLengkap: $namaLengkap, username: $username, password: password_hash($password, PASSWORD_DEFAULT), noTelepon: $noTelepon);

                        $alert = [
                            'title' => 'Succeed',
                            'text' => 'Berhasil mendaftar, silahkan login',
                            'icon' => 'success',
                            'href' => BASE_URL . '/login'
                        ];

                        $_SESSION['alert'] = $alert;
                    } else {
                        $data['error'] = true;
                        $data['message'] = "Username has been registered already";
                    }
                }
            } else {
                $data['error'] = true;
                $data['message'] = "You haven't filled all of the data";
            }
        }

        $this->view('layouts/auth/header', $data);
        $this->view('page/backend/register/index', $data);
        $this->view('layouts/auth/footer', $data);
    }
}
