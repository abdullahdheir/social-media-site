    let arr=[]
$(function(){
    eyePassword("#togglePassword","#login-password")
    eyePassword("#toggleRegisterPassword","#register-password")
    eyePassword("#toggleRegisterRePassword","#register-password-repeat")
    $('#login-email').blur(function(){
        let  value = $(this).val()
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
                if(!pattern.test(value))
                {
                    $('#email-error').html('This Invalid Email Format !!')
                    $('#email-error').show(300)
                    arr[0] = 'email';
                }else {
                    arr[0] = '';
                }
    })
    
     $('#login-email').keyup(function(){
         $('#email-error').hide(300)
     }) 
    
    $('#register-email').blur(function(){
        let  value = $(this).val()
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
                if(!pattern.test(value))
                {
                    $('#register-email-error').html('This Invalid Email Format !!')
                    $('#register-email-error').show(300)
                    arr[0] = 'email';
                }else {
                    arr[0] = '';
                }
    })
    
     $('#register-email').keyup(function(){
         $('#email-error').hide(300)
     })
    
    
    $(document).on('submit','#login-form',function(e){
        e.preventDefault()
        let Form = $(this)
        let password = $('#login-password').val()
        
        if(password ==''){
                $('#password-error').html('Can\'t Be This Feild Emtpy !!')
                $('#password-error').show(300)
                arr[0] = 'password'
        }else{
            arr[0] = ''
        }
        if(arr[0] == ''){   
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
        }
        
    })
    
    
    $(document).on('submit','#register-form',function(e){
        e.preventDefault()
        let Form = $(this)
        let fname = $('#register-fname').val()
        let lname = $('#register-lname').val()
        
        if(fname ==''){
            
            $('#fname-error').html('Can\' Be This Feild Emtpy !!')
            $('#fname-error').show(300)
            arr[0] = 'fname'
            
        }else{
            arr[0] =''
        }
        
         if(lname ==''){
            
            $('#lname-error').html('Can\' Be This Feild Emtpy !!')
            $('#lname-error').show(300)
            arr[0] = 'lname'
            
        }else{
            arr[0] =''
        }
        
        if(arr[0] == ''){
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
        }
    })
    
    $('#register-password').keyup(function(){
        let password = $(this).val()
      var password_strength = document.getElementById("password-text");

      //TextBox left blank.
      if (password.length == 0) {
        password_strength.innerHTML = "";
        return;
      }

      //Regular Expressions.
      var regex = new Array();
      regex.push("[A-Z]"); //Uppercase Alphabet.
      regex.push("[a-z]"); //Lowercase Alphabet.
      regex.push("[0-9]"); //Digit.
      regex.push("[$@$!%*#?&]"); //Special Character.

      var passed = 0;

      //Validate for each Regular Expression.
      for (var i = 0; i < regex.length; i++) {
        if (new RegExp(regex[i]).test(password)) {
          passed++;
        }
      }

      //Display status.
      var strength = "";
      switch (passed) {
        case 0:
        case 1:
        case 2:
          strength = "<small class='progress-bar bg-danger' style='width: 40%; border-radius: 5px; margin-top:5px;'>Weak</small>";
          break;
        case 3:
          strength = "<small class='progress-bar bg-warning' style='width: 60%; border-radius: 5px; margin-top:5px;'>Medium</small>";
          break;
        case 4:
          strength = "<small class='progress-bar bg-success' style='width: 100%; border-radius: 5px; margin-top:5px;'>Strong</small>";
          break;

      }
      password_strength.innerHTML = strength;

    })
    
//    password Eye 
        function eyePassword( toggle = "#toggleLoginPassword",  id = "#login-password"){
            const togglePassword = document.querySelector(toggle);
            const password = document.querySelector(id);

            togglePassword.addEventListener("click", function () {
                // toggle the type attribute
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);

                // toggle the icon
                this.classList.toggle("bi-eye");
            });
        }
    
    $('#register-password-repeat').blur(function(){
        let pass = $('#register-password').val()
        let passre = $(this).val()
        if(pass !== passre){
            $('#register-password-error').html('This Password Not Match')
            $('#register-password-error').show(100)
            arr[0] = 'pass'
        }else{
            arr[0] = ''
        }
    })
})


