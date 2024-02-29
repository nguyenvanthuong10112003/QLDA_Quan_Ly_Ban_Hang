
function validateInput(event) {
    // Lấy giá trị từ sự kiện input
    let inputValue = event.target.value;
    // Loại bỏ mọi ký tự không phải số
    let sanitizedValue = inputValue.replace(/[^0-9]/g, '');
    // Cập nhật giá trị input
    event.target.value = sanitizedValue;
}
