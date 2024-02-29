$(document).ready(function(){
    day365();
    var char = new Morris.Bar({
        
        element: 'myfirstchart',
        xkey: 'date',
        hideHover: 'auto',
        ykeys: ['order', 'revenue','quantity'],
        labels: ['Đơn hàng', 'Doanh thu', 'Số lượng']
    });
    $('.btn-locngay').click(function(){
        var from_date = $('.date_from').val();
        var from_to = $('.date_to').val();

        $.ajax({
            url: "../ajax/thongkedonhang.php",
            method: "POST",
            dataType: "JSON",
            data: {from_date:from_date,from_to:from_to},
            success:function(data){
                char.setData(data);
            }
        })
    })
    $('.select-thongke').change(function(){
        var thoigian = $(this).val();
        if(thoigian == '7ngay'){
            var text = '7 ngày qua';
        }else if(thoigian == '30ngay'){
            var text = '30 ngày qua';
        }else if(thoigian == '90ngay'){
            var text = '90 ngày qua';
        }else {
            var text = '365 ngày qua'
        }
        $('#text-date').text(text);
        $.ajax(
            {
                url: '../ajax/thongkedonhang.php',
                method: 'POST',
                dataType: 'JSON',
                cache: false,
                data:{thoigian:thoigian},
                success: function(data)
                {
                    char.setData(data);
                }
            }
        )
    })
    function day365(){
        var text = '365 ngày qua ';
        $('text-date').text(text);
        $.ajax({
            url: '../ajax/thongkedonhang.php',
            method: 'POST',
            dataType: 'JSON',
            cache: false,
            success: function(data)
            {
                char.setData(data);
            }
        });
    }
});