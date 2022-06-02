$(function () {
    $('.sidebar-menu-link').on('click', function (e) {
        e.preventDefault()
        $('.sidebar-menu-link').each(function (el) {
            $(this).removeClass('active')
        })
        $(this).addClass('active')
        let href = $(this).attr('href')
        $.ajax({
            type: 'GET',
            url: `view/profile/${href}.php`,
            success: function (data) {
                $('#hub-body').html(data)
            }
        })
    });
})