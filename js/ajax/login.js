$(function(){
    $(document).on('submit','#login-form',function(e){
        e.preventDefault()
        let Form = $(this)
        $.ajax({
            type:'POST',
            url:'include/ajax/main.php?do=login',
            beforeSend:function(){
              Form.find("button[type='submit']").append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
               Form.find("button[type='submit']").attr('disabled','true')
            },
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                if(data == 'success'){
                    location.replace('newsfeed.php')
                }else{
                 $('#ajax').html(`<div class="alert alert-danger">${data}</div>`)
                }
            },
            complete:function(data){
                $('.spinner-border').remove()
                Form.find("button[type='submit']").removeAttr('disabled')
            }
        })
    })
    $(document).on('submit','#register-form',function(e){
        e.preventDefault()
        let Form = $(this)
        $.ajax({
            type:'POST',
            url:'include/ajax/main.php?do=register',
            beforeSend:function(){
              Form.find("button[type='submit']").append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
               Form.find("button[type='submit']").attr('disabled','true')
            },
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data){
                $('#ajax').html(data)
                console.log(data)
            },
            complete:function(data){
                $('.spinner-border').remove()
                Form.find("button[type='submit']").removeAttr('disabled')
            }
        })
    })
})