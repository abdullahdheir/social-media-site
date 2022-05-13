$(function(){
    
    $(document).on('click','#logout-btn',function(){
        let s = $(this)
        $.ajax({
            type:'GET',
            url:'include/ajax/main.php?do=logout',
            success:function(data){
                s.append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="height:.7em; width:.7em; margin-left:5px;"></span>')
                setTimeout(function(){
                    location.reload()
                },1500)
            }
        })
    })
})