<?php 
include_once('../interface/IRepository.php');
include_once('../../config/config.php');
include_once('../entity/Product.php');
include_once('../define/KeySession.php');
class ProductRepository implements IRepository
{
    private readonly ConnectDB $connection;
    private readonly string $nameTable;
    public function __construct() {
        $this->connection = new ConnectDB();
        $this->nameTable = "SanPham";
    }
    public function __destruct(){
        $this->connection->closeConn();
    }
    public function getCountProduct(string $search = ''): int {
        $sql = "select * from " . $this->nameTable . " where SP_Ten like '%".$search
        ."%'";
        $result = mysqli_query($this->connection->getConn(), $sql);
        return mysqli_num_rows($result);
    }
    public function getAll(string $search = '', 
        int $item_per_page = 10, int $offset = 0): array {
        $arr = [];
        $sql = "select * from " . $this->nameTable . " where SP_Ten like '%".$search
            ."%' order by SP_Ma limit ". $item_per_page . " offset " . $offset;
        $result = mysqli_query($this->connection->getConn(), $sql);
        if ($result && $result->num_rows > 0) {
            foreach ($result as $item) {
                $product = new Product();
                $product->id = $item['SP_Ma'];
                $product->name = $item['SP_Ten'];
                $product->description = $item['SP_MoTa'];
                $product->material = $item['SP_ChatLieu'];
                $product->price_import = $item['SP_GiaNhap'];
                $product->price = $item['SP_GiaBan'];
                $product->promotion = $item['SP_KhuyenMai'];
                $product->isSelling = $item['SP_TrangThai'];
                $product->count = $item['SP_SoLuongTon'];
                $product->countSold = $item['SP_SoLuongDaBan'];
                $product->ratingRate = $item['SP_TyLeDG'];
                $product->ratingNumber = $item['SP_SoLuongDG'];
                $product->timeCreate = new DateTime($item['SP_ThoiGianThem']);
                $product->gender = $item['SP_GioiTinh'];
                $product->id_member = $item['ND_Ma'];
                $product->sizes = [];
                $sql = "select * from KichThuoc where SP_Ma = " . $product->id . " order by KT_Ten";
                $result1 = mysqli_query($this->connection->getConn(), $sql);
                if ($result1 && $result1->num_rows > 0) 
                    foreach ($result1 as $item1) {
                        $size = new Size();
                        $size->id = $item1['KT_Ma'];
                        $size->name = $item1['KT_Ten'];
                        $size->description = $item1['KT_MoTa'];
                        $size->count = $item1['KT_SoLuongTon'];
                        $size->countSold = $item1['KT_SoLuongDaBan'];
                        $product->sizes = [...$product->sizes, $size];
                    }
                $product->images = [];
                $sql = "select * from AnhSanPham where SP_Ma = " . $product->id . " order by ASP_ThuTu";
                $result1 = mysqli_query($this->connection->getConn(), $sql);
                if ($result1 && $result1->num_rows > 0) 
                    foreach ($result1 as $item1) {
                        $image = new ImageProduct();
                        $image->id = $item1['ASP_Ma'];
                        $image->url = $item1['ASP_DuongDan'];
                        $image->rank = $item1['ASP_ThuTu'];
                        $image->timeCreate = new DateTime($item1['ASP_ThoiGianThem']);
                        $product->images = [...$product->images, $image];
                    }
                $arr = [...$arr, $product];
            }
        } 
        return $arr;
    }
    public function getByPK($id): Product {
        $sql = "select * from " . $this->nameTable . " where SP_Ma = " . $id;
        $result = mysqli_query($this->connection->getConn(), $sql);
        $item = mysqli_fetch_assoc($result);
        $product = new Product();
        $product->id = $item['SP_Ma'];
        $product->name = $item['SP_Ten'];
        $product->description = $item['SP_MoTa'];
        $product->material = $item['SP_ChatLieu'];
        $product->price_import = $item['SP_GiaNhap'];
        $product->price = $item['SP_GiaBan'];
        $product->promotion = $item['SP_KhuyenMai'];
        $product->isSelling = $item['SP_TrangThai'];
        $product->count = $item['SP_SoLuongTon'];
        $product->countSold = $item['SP_SoLuongDaBan'];
        $product->ratingRate = $item['SP_TyLeDG'];
        $product->ratingNumber = $item['SP_SoLuongDG'];
        $product->timeCreate = new DateTime($item['SP_ThoiGianThem']);
        $product->gender = $item['SP_GioiTinh'];
        $product->id_member = $item['ND_Ma'];
        $product->sizes = [];
        $sql = "select * from KichThuoc where SP_Ma = " . $product->id . " order by KT_Ten";
        $result1 = mysqli_query($this->connection->getConn(), $sql);
        if ($result1 && $result1->num_rows > 0) 
            foreach ($result1 as $item1) {
                $size = new Size();
                $size->id = $item1['KT_Ma'];
                $size->name = $item1['KT_Ten'];
                $size->description = $item1['KT_MoTa'];
                $size->count = $item1['KT_SoLuongTon'];
                $size->countSold = $item1['KT_SoLuongDaBan'];
                $product->sizes = [...$product->sizes, $size];
            }
        $product->images = [];
        $sql = "select * from AnhSanPham where SP_Ma = " . $product->id . " order by ASP_ThuTu";
        $result1 = mysqli_query($this->connection->getConn(), $sql);
        if ($result1 && $result1->num_rows > 0) 
            foreach ($result1 as $item1) {
                $image = new ImageProduct();
                $image->id = $item1['ASP_Ma'];
                $image->url = $item1['ASP_DuongDan'];
                $image->rank = $item1['ASP_ThuTu'];
                $image->timeCreate = new DateTime($item1['ASP_ThoiGianThem']);
                $product->images = [...$product->images, $image];
            }
        return $product;
    }
    public function getByName(string $name) {
        $sql = "select * from " . $this->nameTable . " where SP_Ten = '" . $name . "'";
        $result = mysqli_query($this->connection->getConn(), $sql);
        if ($result->num_rows > 0) {
            $item = mysqli_fetch_assoc($result);
            $product = new Product();
            $product->id = $item['SP_Ma'];
            $product->name = $item['SP_Ten'];
            $product->description = $item['SP_MoTa'];
            $product->material = $item['SP_ChatLieu'];
            $product->price_import = $item['SP_GiaNhap'];
            $product->price = $item['SP_GiaBan'];
            $product->promotion = $item['SP_KhuyenMai'];
            $product->isSelling = $item['SP_TrangThai'];
            $product->count = $item['SP_SoLuongTon'];
            $product->countSold = $item['SP_SoLuongDaBan'];
            $product->ratingRate = $item['SP_TyLeDG'];
            $product->ratingNumber = $item['SP_SoLuongDG'];
            $product->timeCreate = new DateTime($item['SP_ThoiGianThem']);
            $product->gender = $item['SP_GioiTinh'];
            $product->id_member = $item['ND_Ma'];
            return $product;
        }
    }
    public function getByUnique(Member $data) {
        $sql = "select * from " . $this->nameTable . " where ND_TenDangNhap = '" . $data->username 
            . "' or ND_SoDienThoai = '" . $data->phoneNumber . "' or ND_Email = '" . $data->email 
            . "' or ND_SoCCCD = '" . $data->soCCCD . "'";
        $result = mysqli_query($this->connection->getConn(), $sql) or die();
        return $result ? mysqli_fetch_assoc($result) : '';
    }
    function update($data) {
        $sql = 'UPDATE ' . $this->nameTable . '
            SET `SP_Ten` = \'' . $data->name . '\', 
            `SP_MoTa` = \'' . $data->description . '\', 
            `SP_ChatLieu` = \'' . $data->material . '\',
            `SP_GiaNhap` = ' . $data->price_import . ', 
            `SP_GiaBan` = ' . $data->price . ', 
            `SP_KhuyenMai` = ' . $data->promotion . ', 
            `SP_SoLuongTon` = ' . $data->count . ', 
            `SP_GioiTinh` = ' . ($data->gender ? 1 : 0) . 
            " WHERE SP_Ma = " . $data->id;
        $listUrl = []; 
        if (mysqli_query($this->connection->getConn(), $sql) or die()) {    
            if ($data->sizes && sizeof($data->sizes) > 0) {
                $sql = "DELETE FROM KichThuoc WHERE SP_Ma = " . $data->id;
                if (mysqli_query($this->connection->getConn(), $sql))
                    foreach ($data->sizes as $size) {
                        $sql = "INSERT INTO KichThuoc (KT_Ten, KT_SoLuongTon, SP_Ma) VALUES ('" 
                            . $size->name . "', " . $size->count . ", " . $data->id . ")";
                        mysqli_query($this->connection->getConn(), $sql) or die();
                    }
            }
            if ($data->images && sizeof($data->images) > 0) {
                $i = 1;
                $sql = "SELECT * from AnhSanPham WHERE SP_Ma = " . $data->id;
                $rs = mysqli_query($this->connection->getConn(), $sql);
                if ($rs && $rs->num_rows > 0) {
                    foreach($rs as $image) 
                        $listUrl = [...$listUrl, $image['ASP_DuongDan']];
                }
                $sql = "DELETE FROM AnhSanPham WHERE SP_Ma = " . $data->id;
                if (mysqli_query($this->connection->getConn(), $sql))
                    foreach ($data->images as $image) {
                        $sql = "INSERT INTO AnhSanPham (ASP_DuongDan, ASP_ThuTu, ASP_ThoiGianThem, SP_Ma) VALUES ('" 
                            . $image->url . "', " . $i++ . ", '" . date('Y/m/d H:i:S') . "', " . $data->id . ")";
                        mysqli_query($this->connection->getConn(), $sql) or die();
                    }
            }
            return $listUrl;
        }
    }
    public function create($data) {
        $data->timeCreate = date_create();
        $sql = 'INSERT INTO ' . $this->nameTable . ' 
            (`SP_Ten`, `SP_MoTa`, `SP_ChatLieu`, 
            `SP_GiaNhap`, `SP_GiaBan`, `SP_KhuyenMai`, 
            `SP_TrangThai`, `SP_SoLuongTon`, `SP_ThoiGianThem`, 
            `SP_GioiTinh`, `ND_Ma`) 
            VALUES (\'' . $data->name . "', '" . $data->description 
            . "','" . $data->material . "', " . $data->price_import . ", " . $data->price 
            . "," . $data->promotion . ",1, " . $data->count
            . ",'" . $data->timeCreate->format('Y/m/d H:i:s') . "', " . ($data->gender ? 1 : 0) . ", " . json_decode($_SESSION[KeySession::userLogin->value])->id . ")";
        $result = mysqli_query($this->connection->getConn(), $sql) or die();
        if ($result) {
            $newProduct = $this->getByName($data->name);
            if ($newProduct !== null) {        
                if ($data->sizes && sizeof($data->sizes) > 0) {
                    foreach ($data->sizes as $size) {
                        $sql = "INSERT INTO KichThuoc (KT_Ten, KT_SoLuongTon, SP_Ma) VALUES ('" 
                            . $size->name . "', " . $size->count . ", " . $newProduct->id . ")";
                        mysqli_query($this->connection->getConn(), $sql) or die();
                    }
                }
                if ($data->images && sizeof($data->images) > 0) {
                    $i = 1;
                    foreach ($data->images as $image) {
                        $sql = "INSERT INTO AnhSanPham (ASP_DuongDan, ASP_ThuTu, ASP_ThoiGianThem, SP_Ma) VALUES ('" 
                            . $image->url . "', " . $i++ . ", '" . date('Y/m/d H:i:S') . "', " . $newProduct->id . ")";
                        mysqli_query($this->connection->getConn(), $sql) or die();
                    }
                }
                return true;
            }
        }
    }
}
