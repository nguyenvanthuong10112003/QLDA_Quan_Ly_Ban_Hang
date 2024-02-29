<?php
session_start();
include_once('../define/KeySession.php');
include('../includes/header.php');
include('../helper/FormatDateTime.php');
include_once('../data/ProductRepository.php');
include_once('../helper/ValidationStringHelper.php');
if (!(isset($_SESSION[KeySession::permission->value]) &&
$_SESSION[KeySession::permission->value] == 'personnel')) {
    header("Location: ../home/index.php");
    exit(0);
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $context = new ProductRepository();
    // Xử lý Ajax request
    $search = isset($_GET["input_value"]) ? $_GET["input_value"] : '';
    include("../pagination/offset.php");
    $datas = $context->getAll($search, $item_per_page, $offset);
    $totalRecords = $context->getCountProduct($search);
    // Tổng số trang = tổng số sản phẩm / tổng số sản phẩm một trang
    $totalPage = ceil($totalRecords / $item_per_page);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="container-fluid px-4">
    <div class="float-end">
    <form style="display: inline-flex;" name=f method="get">
        <input class="form-control txtSearch" name="input_value" type="text" required style="margin-left:0;"  placeholder="Tìm kiếm..." value="<?= isset($search) ? $search : '' ?>" />                          
    </form></div>
    <ol class="breadcrumb mt-5">
        <li class="breadcrumb-item active">Sản phẩm</li>
        <li class="breadcrumb-item">Danh sách sản phẩm</li>
    </ol>
    <?php 
        if (isset($_SESSION[KeySession::sysrequest->value])) {
            $request = json_decode($_SESSION[KeySession::sysrequest->value]);
            if (isset($request) && $request->message) {
                echo '<span class="fw-bolder ' . ($request->status == 1 ? 'text-success' : 'text-danger') . "\">" . $request->message . "</span>";
            }
            $_SESSION[KeySession::sysrequest->value] = null;
        } 
    ?>
    <div class="Prod highlight" id="user_table" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách sản phẩm</h4>
                    <a href="product_add.php" class="btn btn-primary float-start"><i class="fa-solid fa-plus" style="margin-right: 5px;"></i>Thêm</a>
                </div>
                <div class="card-body highlight" style="overflow: auto;">
                    <table class="table table-bordered">
                        <tr>
                            <th>Ảnh</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Phái</th>
                            <th>Chất liệu</th>
                            <th>Kích thước</th>
                            <th>Giá nhập</th>
                            <th>Giá bán</th>
                            <th>Khuyến mại</th>
                            <th>Trạng thái</th>
                            <th>Tồn</th>
                            <th>Đã bán</th>
                            <th>Đánh giá</th>
                            <th>Thời gian thêm</th>
                            <th>Người thêm</th>
                            <th>Hành động</th>
                        </tr>
                        <?php
                        if (sizeof($datas) > 0) {
                            foreach ($datas as $row) {
                        ?>
                            <tr style="box-sizing: border-box;">
                                <th scope="row" class="d-flex flex-row" style="max-width: 150px; height: 150px; overflow: auto;">
                                    <?= sizeof($row->images) == 0 ? '' : 
                                        array_reduce($row->images, function($result, $item) {
                                            return $result . '<img src="' . (ValidationStringHelper::hadKey($item->url, '/') ? $item->url : ('../../images/' . $item->url)) . '">';
                                        }, ''); 
                                    ?>
                                </th>
                                <th><?= $row->id; ?></th>
                                <td><?= $row->name; ?></td>
                                <td><?= $row->description; ?></td>
                                <td><?= $row->gender ? 'Nam' : 'Nữ'; ?></td>
                                <td><?= $row->material; ?></td>
                                <td>
                                    <?= sizeof($row->sizes) == 0 ? '' : 
                                        array_reduce($row->sizes, function($result, $item) {
                                            
                                            return $result . (strlen($result) == 0 ? $item->name : '-' . $item->name);
                                        }, ''); 
                                    ?>
                                </td>
                                <td><?= $row->price_import; ?></td>
                                <td><?= $row->price; ?></td>
                                <td><?= $row->promotion; ?></td>
                                <td><?= $row->isSelling ? 'Đang kinh doanh' : 'Ngừng kinh doanh' ?></td>
                                <td><?= $row->count; ?></td>
                                <td><?= $row->countSold; ?></td>
                                <td><?= $row->ratingRate . '/' . $row->ratingNumber; ?></td>
                                <td><?= $row->timeCreate->format('H:i:s d/m/Y'); ?></td>
                                <td><a href="#"><?= $row->id_member; ?></a></td>
                                <td>
                                    <a href="./product_edit.php?id=<?= $row->id; ?>" class="btn btn-primary">Sửa</a>
                                </td>
                            </tr>
                        <?php
                            }
                        }}
                        ?>
                    </table>
                    <?php include("../pagination/pagination.php") ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../includes/footer.php');
?>