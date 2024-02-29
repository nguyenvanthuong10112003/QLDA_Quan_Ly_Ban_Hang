for(let i=0; i<=6; i++){
    $(`.checkbox_wrapper_${i}`).on('click', function(){
        $(this).parents('.card').find(`.checkbox_children_${i}`).prop('checked', $(this).prop('checked'));
    }) 
}