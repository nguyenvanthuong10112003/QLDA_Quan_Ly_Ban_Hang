<?php 
include('../interface/IRepository.php');
include('../../config/config.php');
include('../entity/Member.php');
class MemberRepository implements IRepository
{
    private readonly ConnectDB $connection;
    private readonly string $nameTable;
    public function __construct() {
        $this->connection = new ConnectDB();
        $this->nameTable = "NguoiDung";
    }
    public function __destruct(){
        $this->connection->closeConn();
    }
    public function getAll(): array {
        $arr = [];
        $sql = "select * from " . $this->nameTable;
        $result = mysqli_query($this->connection->getConn(), $sql) or die($this->connection);
        if ($result && $result->num_rows > 0) {
            foreach ($result as $item) {
                $member = new Member();
                $member->id = $item['ND_Ma'];
                $member->username = $item['ND_TenDangNhap'];
                $member->isOnline = $item['ND_TrangThaiHD'];
                $member->isLock = $item['ND_TranGThaiKhoa'];
                $member->isAdmin = $item['ND_QuyenAdmin'];
                $member->isPersonnel = $item['ND_QuyenNV'];
                $member->dateCreate = new DateTime($item['ND_ThoiGianTao']);
                $member->fullName = $item['ND_HoVaTen'];
                $member->email = $item['ND_Email'];
                $member->phoneNumber = $item['ND_SoDienThoai'];
                $member->gender = $item['ND_GioiTinh'];
                $member->dateOfBirth = new DateTime($item['ND_NgaySinh']);
                $member->address = $item['ND_DiaChi'];
                $member->soCCCD = $item['ND_SoCCCD'];
                $member->urlAvatar = $item['ND_AnhDaiDien'];
                $arr = [...$arr, $member];
            }
        } 
        return $arr;
    }
    public function getAllPersonnel(string $search = '', 
        int $item_per_page = 10, int $offset = 0): array {
        $arr = [];
        $sql = "select * from " . $this->nameTable . " where ND_QuyenNV = 1 and ND_HoVaTen like '%".$search
            ."%' order by ND_Ma limit ". $item_per_page . " offset " . $offset;
        $result = mysqli_query($this->connection->getConn(), $sql) or die($this->connection);
        if ($result && $result->num_rows > 0) {
            foreach ($result as $item) {
                $member = new Member();
                $member->id = $item['ND_Ma'];
                $member->username = $item['ND_TenDangNhap'];
                $member->isOnline = $item['ND_TrangThaiHD'];
                $member->isLock = $item['ND_TranGThaiKhoa'];
                $member->isAdmin = $item['ND_QuyenAdmin'];
                $member->isPersonnel = $item['ND_QuyenNV'];
                $member->dateCreate = new DateTime($item['ND_ThoiGianTao']);
                $member->fullName = $item['ND_HoVaTen'];
                $member->email = $item['ND_Email'];
                $member->phoneNumber = $item['ND_SoDienThoai'];
                $member->gender = $item['ND_GioiTinh'];
                $member->dateOfBirth = new DateTime($item['ND_NgaySinh']);
                $member->address = $item['ND_DiaChi'];
                $member->soCCCD = $item['ND_SoCCCD'];
                $member->urlAvatar = $item['ND_AnhDaiDien'];
                $arr = [...$arr, $member];
            }
        } 
        return $arr;
    }
    public function getCountPersonnel(string $search = ''): int {
        $sql = "select count(*) as count from " . $this->nameTable . " where ND_QuyenNV = 1 and ND_HoVaTen like '%" . $search . "%'";
        $result = mysqli_query($this->connection->getConn(), $sql) or die($this->connection);
        return mysqli_fetch_assoc($result)['count'];
    }
    public function getAllCustomer(): array {
        $arr = [];
        $sql = "select * from " . $this->nameTable . " where ND_QuyenNV = 0 and ND_QuyenAdmin = 0";
        $result = mysqli_query($this->connection->getConn(), $sql) or die();
        if ($result && $result->num_rows > 0) {
            foreach ($result as $item) {
                $member = new Member();
                $member->id = $item['ND_Ma'];
                $member->username = $item['ND_TenDangNhap'];
                $member->isOnline = $item['ND_TrangThaiHD'];
                $member->isLock = $item['ND_TranGThaiKhoa'];
                $member->isAdmin = $item['ND_QuyenAdmin'];
                $member->isPersonnel = $item['ND_QuyenNV'];
                $member->dateCreate = new DateTime($item['ND_ThoiGianTao']);
                $member->fullName = $item['ND_HoVaTen'];
                $member->email = $item['ND_Email'];
                $member->phoneNumber = $item['ND_SoDienThoai'];
                $member->gender = $item['ND_GioiTinh'];
                $member->dateOfBirth = new DateTime($item['ND_NgaySinh']);
                $member->address = $item['ND_DiaChi'];
                $member->soCCCD = $item['ND_SoCCCD'];
                $member->urlAvatar = $item['ND_AnhDaiDien'];
                $arr = [...$arr, $member];
            }
        } 
        return $arr;
    }
    public function getByPK($id): Member {
        if (is_int($id) && $id > 0) {
            $sql = "select * from " . $this->nameTable . " where ND_Ma = " . $id;
            $result = mysqli_query($this->connection->getConn(), $sql) or die();
            if ($result->num_rows == 0)
                return null;
            $item = mysqli_fetch_assoc($result);
            $member = new Member();
            $member->id = $item['ND_Ma'];
            $member->username = $item['ND_TenDangNhap'];
            $member->isOnline = $item['ND_TrangThaiHD'];
            $member->isLock = $item['ND_TranGThaiKhoa'];
            $member->isAdmin = $item['ND_QuyenAdmin'];
            $member->isPersonnel = $item['ND_QuyenNV'];
            $member->dateCreate = new DateTime($item['ND_ThoiGianTao']);
            $member->fullName = $item['ND_HoVaTen'];
            $member->email = $item['ND_Email'];
            $member->phoneNumber = $item['ND_SoDienThoai'];
            $member->gender = $item['ND_GioiTinh'];
            $member->dateOfBirth = new DateTime($item['ND_NgaySinh']);
            $member->address = $item['ND_DiaChi'];
            $member->soCCCD = $item['ND_SoCCCD'];
            $member->urlAvatar = $item['ND_AnhDaiDien'];
            return $member;
        }
    }
    public function getByUsername(string $username): Member {
        $sql = "select * from " . $this->nameTable . " where ND_TenDangNhap = '" . $username . "'";
        $result = mysqli_query($this->connection->getConn(), $sql) or die();
        if ($result->num_rows == 0)
            return null;
        $item = mysqli_fetch_assoc($result);
        $member = new Member();
        $member->id = $item['ND_Ma'];
        $member->username = $item['ND_TenDangNhap'];
        $member->password_hash = $item['ND_MatKhau'];
        $member->isOnline = $item['ND_TrangThaiHD'];
        $member->isLock = $item['ND_TranGThaiKhoa'];
        $member->isAdmin = $item['ND_QuyenAdmin'];
        $member->isPersonnel = $item['ND_QuyenNV'];
        $member->dateCreate = new DateTime($item['ND_ThoiGianTao']);
        $member->fullName = $item['ND_HoVaTen'];
        $member->email = $item['ND_Email'];
        $member->phoneNumber = $item['ND_SoDienThoai'];
        $member->gender = $item['ND_GioiTinh'];
        $member->dateOfBirth = new DateTime($item['ND_NgaySinh']);
        $member->address = $item['ND_DiaChi'];
        $member->soCCCD = $item['ND_SoCCCD'];
        $member->urlAvatar = $item['ND_AnhDaiDien'];
        return $member;
    }
    public function getByUnique(Member $data) {
        $sql = "select * from " . $this->nameTable . " where ND_TenDangNhap = '" . $data->username 
            . "' or ND_SoDienThoai = '" . $data->phoneNumber . "' or ND_Email = '" . $data->email 
            . "' or ND_SoCCCD = '" . $data->soCCCD . "'";
        $result = mysqli_query($this->connection->getConn(), $sql) or die();
        return $result ? mysqli_fetch_assoc($result) : '';
    }
    function update($data) {

    }
    public function updateOnline(Member $data): bool {
        $sql = "update " . $this->nameTable . " set ND_TrangThaiHD = " . ($data->isOnline ? 1 : 0) . " where ND_Ma = '" . $data->id . "'";
        return mysqli_query($this->connection->getConn(), $sql) or die();
    }
    public function updateLock(Member $data): bool {
        $sql = "update " . $this->nameTable . " set ND_TrangThaiKhoa = " . ($data->isLock ? 1 : 0) . " where ND_Ma = '" . $data->id . "'";
        return mysqli_query($this->connection->getConn(), $sql) or die();
    }
    public function updatePassword(Member $data): bool {
        $sql = "update nguoidung set ND_MatKhau = '" . $data->password_hash . "' where ND_TenDangNhap = '" . $data->username . "'"; 
        return mysqli_query($this->connection->getConn(), $sql) or die();
    }
    public function create($data): bool {
        $sql = "INSERT INTO " . $this->nameTable . " 
        (ND_TenDangNhap, ND_MatKhau, ND_QuyenNV, 
        ND_ThoiGianTao, ND_HoVaTen, ND_Email, 
        ND_SoDienThoai, ND_GioiTinh, ND_NgaySinh, 
        ND_DiaChi, ND_SoCCCD)
        VALUES ('" . $data->username . "', '" . $data->password_hash . "', 1, 
            '" . Date('Y/m/d H:i:s') . "', '" . $data->fullName . "', '" . $data->email . "', 
            '" . $data->phoneNumber ."', ". $data->gender . ", '" . $data->dateOfBirth->format('Y/m/d') . "', 
            '" . $data->address . "', '" . $data->soCCCD . "')";
        $result = mysqli_query($this->connection->getConn(), $sql);
        return $result;
    }
}
