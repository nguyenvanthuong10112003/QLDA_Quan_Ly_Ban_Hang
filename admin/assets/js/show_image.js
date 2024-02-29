const inputImg = document.querySelector('#input-img')
inputImg.addEventListener('input', (e) => {
    let file = e.target.files[0]
    if (!file) return
    document.querySelector(".img_preview").src = URL.createObjectURL(file)
    document.querySelector("#avt_link_img").value = inputImg.value.substring(inputImg.value.lastIndexOf('\\') + 1);
    document.querySelector('.preview').appendChild(img)
})

window.onload = function() {
    openModal();
}