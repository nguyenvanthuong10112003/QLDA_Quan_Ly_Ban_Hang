<?php
session_start();
include_once('../includes/header.php');
include_once('../includes/navbar_top.php');
include_once('../includes/sidebar.php');
include_once('../define/KeySession.php');
if (!(isset($_SESSION[KeySession::permission->value]) &&
$_SESSION[KeySession::permission->value] == 'personnel')) {
    header("Location: ../home/index.php");
    exit(0);
}

if (isset($_SESSION[KeySession::sysrequest->value])) {
    $request = json_decode($_SESSION[KeySession::sysrequest->value]);
    if (isset($request->data))
        $entityRequest = $request->data;
    $_SESSION[KeySession::sysrequest->value] = null;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Sản Phẩm Mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
</head>

<body>
    <style>
        .error-input {
            border-color: #DC3545;  
            box-shadow: 0 0 0 0.05rem rgb(235 0 0 / 55%)
        }

        button:disabled {
            opacity: 0.6;
        }

        #error-image {
            position: absolute;
            right: 15px;
        }
    </style>
    <div class="container-fluid px-4">
        <ol class="breadcrumb mt-5">
            <li class="breadcrumb-item active">Sản phẩm</li>
            <li class="breadcrumb-item active">Thêm sản phẩm</li>
        </ol>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <?php 
                            if (isset($request) && $request->status === 0 && $request->message) 
                                echo '<span class="fw-bolder text-danger">' . $request->message . "</span>";
                        ?>
                        <form id="form-add" action="./product_add_action.php" method="post" onsubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input required type="text" class="form-control" name="product-name" value="<?= isset($entityRequest) ? $entityRequest->name : '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Mô tả sản phẩm</label>
                                <input type="text" class="form-control" name="product-description" value="<?= isset($entityRequest) ? $entityRequest->description : '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Chất liệu</label>
                                <input type="text" class="form-control" name="product-material" value="<?= isset($entityRequest) ? $entityRequest->material : '' ?>">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;">Phái</label>
                                <div class="form-control d-flex flex-row">
                                    <div class="form-check me-3">
                                        <input required class="form-check-input" type="radio" name="product-gender" id="male" value="1"
                                            <?= isset($entityRequest) ? ($entityRequest->gender ? 'checked' : '') : '' ?>>                                    
                                        <label class="form-check-label" for="male">Nam</label>
                                    </div>
                                    <div class="form-check">
                                        <input required class="form-check-input" type="radio" name="product-gender" id="female" value="0"
                                            <?= isset($entityRequest) ? ($entityRequest->gender ? '' : 'checked') : '' ?>>                                    
                                        <label class="form-check-label" for="female">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex flex-column">
                                <label>Kích thước <span id="error-size" class="text-danger float-end"></span></label>
                                <span id="list-size">

                                </span>
                                <button type="button" id="btn-add-size" class="btn btn-outline-primary">Thêm</button>
                            </div>
                            <div class="form-group">
                                <label>Giá nhập</label>
                                <input required step="0.01" type="number" class="form-control" name="product-price-import" value="<?= isset($entityRequest) ? ($entityRequest->price_import) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Giá bán</label>
                                <input required step="0.01" type="number" class="form-control" name="product-price" value="<?= isset($entityRequest) ? $entityRequest->price : '' ?>">
                            </div>
                            <div class="form-group">
                                <label>Khuyến mại (%)</label>
                                <input type="number" step="0.01" class="form-control" name="product-promotion" min="0" max="100" value="<?= isset($entityRequest) ? $entityRequest->promotion : '0' ?>">
                            </div>
                            <div class="form-group">
                                <label>Ảnh sản phẩm <span id="error-image" class="text-danger float-end"></span></label>
                                <br>
                                <button type="button" id="btn-add-image" class="btn btn-outline-primary">Thêm ảnh</button>
                                <input type="file" class="form-control d-none" id="input-img-select" multiple accept="image/*">
                                <input type="file" class="form-control d-none" name="images[]" id="box-images" multiple accept="image/*">
                                <span id="list-images" class="d-flex flex-row flex-wrap justify-content-between mt-1">
                                </span>
                            </div>
                            <input name="btn-add" value="Xác nhận" type="submit" class="btn btn-primary mt-2">
                            <a href="product_list.php" class="btn btn-secondary mt-2">Hủy bỏ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script>
        function validate() {
            if ($('#list-size').children().length === 0) {
                $('#error-size').text('Cần tối thiểu một kích thước');
                return false;
            }
            if (document.getElementById('box-images').files.length === 0) {
                $('#error-image').text('Cần tối thiểu một ảnh về sản phẩm');
                return false;
            }
            return true;
        }
        var start =function () {
            let listSizes = [
                <?php 
                    if (isset($entityRequest) && $entityRequest->sizes)
                        foreach($entityRequest->sizes as $size) {
                            if ($size !== $entityRequest->sizes[0]) 
                                echo ",";
                            echo '{name: \'' . $size->name . '\', count: ' . $size->count . '}';
                        }
                ?>
            ]
            Array.from(listSizes).forEach(element => addItemSize(undefined, element.name, element.count))
            if (document.getElementById('box-images').files.length > 0)
            {
                let changeEvent = new Event("change");
                document.getElementById('input-img-select').dispatchEvent(changeEvent);
            }
        }
        $(document).ready(() => {
            $('#btn-add-image').click(() => {
                $('#input-img-select').click()
            })
            $('#input-img-select').change(() => {
                console.log('ok');
                var lists =new DataTransfer();
                Array.from(document.getElementById('box-images').files).forEach(item => {
                    lists.items.add(item)
                });
                Array.from(document.getElementById('input-img-select').files).forEach(item => {
                    lists.items.add(item)
                });
                document.getElementById('box-images').files = lists.files;
                Array.from(document.getElementById('input-img-select').files).forEach(
                    (file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const boxImage = document.createElement('span');
                            boxImage.style = 'display: flex; flex-direction: column; align-items: center;';
                            const radioButton = document.createElement('input');
                            radioButton.type = 'radio';
                            radioButton.name = 'is-main';
                            radioButton.className = 'select-main';
                            radioButton.style = 'margin: 5px 0 3px 0';
                            radioButton.value = file.name;
                            radioButton.id = file.name.trim();
                            const labelRadioButton = document.createElement('label');
                            labelRadioButton.innerText = 'Chính';
                            labelRadioButton.classList = 'label-select-is-main';
                            const imageDataURL = e.target.result;
                            const image = new Image();
                            image.src = imageDataURL;
                            image.style = 'width: 50%; min-width: 300px; min-height: 300px; margin: 1px;';
                            const labelImage =document.createElement('label');
                            const btnClose =document.createElement('button');
                            btnClose.type = "button";
                            btnClose.classList ="bg-danger btn-del-image";
                            btnClose.style = 'padding: 10px 0; width: 100%; cursor: pointer; border: 0';
                            btnClose.innerHTML = '<i class="fa-solid fa-xmark text-white"></i>'
                            btnClose.onclick = () => {
                                boxImage.remove();
                                for (let i = 0; i < lists.files.length; i++) {
                                    if (lists.files[i].name === file.name) 
                                    {
                                        lists.items.remove(i);
                                        break;
                                    }
                                }
                                document.getElementById('box-images').files = lists.files;
                            }
                            radioButton.onchange = () => {
                                $('.label-select-is-main').attr('class', 'label-select-is-main d-none');
                                labelRadioButton.classList = 'label-select-is-main';
                                $('.btn-del-image').removeAttr('disabled')
                                btnClose.setAttribute("disabled", true);
                            }
                            if (index != 0)
                                labelRadioButton.classList += ' d-none';
                            else {
                                if (!$('.select-main').prop('checked')) {
                                    radioButton.checked = true;
                                    btnClose.setAttribute('disabled', true);
                                }
                                else
                                    labelRadioButton.classList += ' d-none';
                            }
                            labelImage.classList = 'position-relative';
                            labelImage.style = 'border: 1px solid rgba(0,0,0,0.2);';
                            labelImage.setAttribute('for', file.name.trim());
                            labelImage.appendChild(image);
                            boxImage.appendChild(btnClose);
                            boxImage.appendChild(labelImage);
                            boxImage.appendChild(radioButton);
                            boxImage.appendChild(labelRadioButton);
                            document.getElementById('list-images').appendChild(boxImage);
                        };
                        reader.readAsDataURL(file);
                    }
                )
            })
            $('#btn-add-size').click(addItemSize);
        })
        var addItemSize = (event, name, count) => {
            $('#error-size').text('');
            const list = document.getElementById('list-size');
            
            const formGroup =document.createElement('div');
            formGroup.classList = 'form-group d-flex flex-row align-items-center mb-2';
            
            const inputName =document.createElement('input');
            inputName.type = 'text';
            inputName.classList = 'input-name-size form-control';
            inputName.name = 'nameSizes[]';
            inputName.placeholder = 'Tên';
            inputName.required = true;
            if (name)
                inputName.value = name;

            const inputCount =document.createElement('input');
            inputCount.type = 'number';
            inputCount.classList = 'input-value-size form-control ms-2 me-2';
            inputCount.name = 'valueSizes[]';
            inputCount.placeholder = 'Số lượng';
            inputCount.min = "0";
            inputCount.required = true;
            if (count)
                inputCount.value = count;

            const btnDel =document.createElement('button');
            btnDel.type="button";
            btnDel.classList="btn btn-danger";
            btnDel.onclick = () => {
                $(formGroup).remove();
            }
            btnDel.innerText = "Xóa";

            formGroup.appendChild(inputName);
            formGroup.appendChild(inputCount);
            formGroup.appendChild(btnDel);
            list.appendChild(formGroup);
            $('.input-name-size').keyup(() => {
                const list = $('.input-name-size').toArray();
                let map = [];
                let check = [];
                list.forEach((element, index) => {
                    $(element).removeClass('error-input');
                    if (map.find((item) => item == element.value) == -1) 
                        map = [...map, element.value];
                    else if (check.find((item) => item == element.value)) {
                        $(element).addClass('error-input');
                    } else 
                        check = [...check, element.value];
                })
            }) 
        }
        window.onload = () => {
            start();
        }
    </script>
    <?php include('../includes/footer.php');
    ?>
    <script src="../../admin/assets/js/validateInput.js"></script>
</body>
</html>