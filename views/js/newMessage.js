$(function(){
    $('.ami').on("click",function(){
        $('html, body').animate({ scrollTop: 0 }, 'slow')
        $('.fenetre-messages').html('')
        $(".modale-message").addClass("d-block")
        $(".modale-message").removeClass("d-none")
        $(".fond-flou").addClass("d-block")
        $(".fond-flou").removeClass("d-none")
        var form = new FormData();
        let xhr = new XMLHttpRequest()
        let url = "../modeles/sendMessage.php"
        let messageEnv = ""
        let destination = $(this).attr('id') 
        console.log(destination) 
        $('.fond-flou').off("click").on('click',function(){
            $('.modale-message').addClass('d-none')
            $('.modale-message').removeClass('d-block')
            $('.fond-flou').addClass('d-none')
            $('.fond-flou').removeClass('d-block')
        })
        $('.buttonSend').off("click").on("click",function(){
            let message = $('.sendMessage textarea').val()
            if(message != ""){
                xhr.open('POST',url)
                form.append('destination',destination)
                form.append('message',message)
                xhr.send(form)
                xhr.onreadystatechange=function(){
                    if(xhr.readyState == 4 && xhr.status === 200) {
                        contenuMessage = "<div class='message-env bg-success'>"+message+"</div>"
                        $('.fenetre-messages').html($('.fenetre-messages').html()+contenuMessage)
                        $('.sendMessage textarea').val("")
                    }
                }

            }

            // console.log(message)
        })
    })
    
})