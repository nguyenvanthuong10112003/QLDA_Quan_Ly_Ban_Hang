<?php
session_start();
include_once('../define/KeySession.php');
include_once('../data/ProductRepository.php');
include_once('../entity/SysRequest.php');
include_once('../entity/Product.php');
if (!(isset($_SESSION[KeySession::permission->value]) &&
$_SESSION[KeySession::permission->value] == 'personnel')) {
    header("Location: ../home/index.php");
    exit(0);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./product_list.php');
    exit(0);
}
if (isset($_POST['btn-edit'])) {
    $product = new Product();
    $product->id = $_POST['product-id'];
    $product->name = $_POST['product-name'];
    $product->description = $_POST['product-description'];
    $product->material = $_POST['product-material'];
    $product->price_import = $_POST['product-price-import'];
    $product->price = $_POST['product-price'];
    $product->promotion = $_POST['product-promotion'];
    $product->gender = $_POST['product-gender'];
    $product->sizes = [];
    $product->images = [];
    $countSize = sizeof($_POST['nameSizes']);
    for ($i= 0; $i < $countSize; $i++) {
        $size = new Size();
        $size->name = $_POST['nameSizes'][$i];
        $size->count = $_POST['valueSizes'][$i];
        $product->sizes = [...$product->sizes, $size];
    }

    //validate
    $messageError = '';
    if (!isset($_POST['product-name']) || strlen(str_replace(' ', '', $_POST['product-name'])) == 0)
    {
        $messageError = $messageError . 'Tên sản phẩm không được để trống';
    }
    if (sizeof($product->sizes) === 0) 
    {
        $messageError = $messageError . (strlen($messageError) > 0 ? '. ' : '') . 'Phải có ít nhất một kích thước';
    } else {
        $product->count = array_reduce($product->sizes, function($result, $item) {
            return $result + $item->count;
        }, 0);
    }
    if (!isset($_FILES['images']) || sizeof($_FILES['images']) === 0) 
    {
        $messageError = $messageError . (strlen($messageError) > 0 ? '. ' : '') . 'Phải có ít nhất một ảnh';
    }

    if (strlen($messageError) > 0) {
        $_SESSION[KeySession::sysrequest->value] = json_encode(new SysRequest(
                0, 
                $messageError, 
                null
            ));
        header("Location: product_edit.php?id=" . $product->id);
        exit(0);
    }

    $main = $_POST['is-main'];
    $countImage = sizeof($_FILES['images']['name']);
    if ($countImage == 0) {
        $_SESSION[KeySession::sysrequest->value] = json_encode(
            new SysRequest(0, "Sản phẩm phải có ít nhất một ảnh", null));
        header("Location: product_edit.php?id=" . $product->id);
        exit(0);
    }

    $context = new ProductRepository();
    $rerult_check_product_id = $context->getByPK($product->id);
    if (!$rerult_check_product_id) {
        $_SESSION[KeySession::sysrequest->value] = json_encode(
            new SysRequest(0, "Sản phẩm không tồn tại", null));
        header("Location: product_edit.php?id=" . $product->id);
        exit(0);
    }
    $rerult_check_product_name = $context->getByName($product->name);
    if ($rerult_check_product_name && $rerult_check_product_name->id !== $product->id) {
        $_SESSION[KeySession::sysrequest->value] = json_encode(
            new SysRequest(0, "Sản phẩm: " . $product->name . " đã tồn tại!", null));
        header("Location: product_edit.php?id=" . $product->id);
    } else {
        $countSuccess = 0;
        for ($i= 0; $i < $countImage; $i++) {
            $image = new ImageProduct();
            if ($_FILES['images']['type'][$i] == 'image/jpeg' || $_FILES['images']['type'][$i] == 'image/jpg' ||  $_FILES['images']['type'][$i] == 'image/png') {
                $image->url = date('Y-m-d-H-i-s') . $_FILES['images']['name'][$i];
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], "../../images/" . $image->url)) {
                    $product->images = [...$product->images, $image];
                    if ($_FILES['images']['name'][$i] == $main) {
                        $countSuccess++;
                        $temp = $product->images[$i];
                        for ($j = $i; $j > 0; $j--) {
                            $product->images[$j] = $product->images[$j - 1];
                        }
                        $product->images[0] = $temp;
                    } 
                }
            }        
        }
        if ($countSuccess == 0) {
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(0, "Tất cả ảnh đều không hợp lệ", null));
            header("Location: product_edit.php?id=" . $product->id);
            exit(0);
        }
        $rs = $context->update($product);
        if (is_array($rs)) {
            foreach ($rs as $url) {
                if (file_exists('../../images/' . $url)) {
                    unlink('../../images/' . $url);
                }
            }
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    1, 
                    "Cập nhật thành công", 
                    null
                )
            );
            header('Location: product_list.php');

        } else {
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    0, 
                    "Đã xảy ra sự cố", 
                    null
                )
            );
            header('Location: product_edit.php?id=' . $product->id);
        }
    }
} else {
    header('Location: ./product_list.php');
}
