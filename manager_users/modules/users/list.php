<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

$data = [
    'pageTitle' => 'Danh sach user'
];

layouts('header', $data);
layouts('navbar');
// Kiem tra trang thai dang nhap

if (!isLogin()) {
    redirect('?module=auth&action=login');
}

// Truy van vao bang users
$listUsers = getRaw("SELECT * FROM users ORDER BY update_at");

// echo '<pre>';
// print_r($listUsers);
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>

<div class="container ">
    <h2 class="modal-title my-3 ">Danh sach nguoi dung</h2>
    <?php if (!empty($smg)) {
        getSmg($smg, $smg_type);
    } ?>
    <p>
        <a href="?module=users&action=add" class="btn btn-success ">Add</a>
    </p>
    <table class="table table-bordered ">
        <thead>
            <tr>
                <th>Num#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($listUsers)) :
                $count = 1;
                foreach ($listUsers as $item) :
            ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $item['fullname']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <td><?= $item['phone']; ?></td>
                        <td><?= $item['status'] == 1 ? '<button class="btn  btn-success btn-sm ">Active</button>' :
                                '<button class="btn  btn-danger  btn-sm ">Un-Active</button>'; ?></td>
                        <td>
                            <a href="<?= _WEB_HOST  ;?>?module=users&action=edit&id=<?= $item['id']; ?>" class="btn btn-warning ">Edit</a>
                            <a href="<?= _WEB_HOST  ;?>?module=users&action=delete&id=<?= $item['id']; ?>" onclick="return confirm('Ban co chac chan muon xoa khong ?')" class="btn btn-danger mx-2  ">Delete</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="6">
                        <div class="alert alert-danger text-center ">Danh sac trong, Khong co nguoi dung trong he thong !</div>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>

<?php
layouts('footer');

?>