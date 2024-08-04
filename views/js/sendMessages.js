function sendMessage(){
    let destination=''
    var form = new FormData()
    let xhr = new XMLHttpRequest()
    let url = "../modeles/sendMessage.php"
    let messageEnv
    $('.discussion').click(function(){
        idDisc = $(this).attr('value')
        destination = $(this).attr('id')
        $('.sendMessage button').off('click').on('click',function(){
            let message = $('.sendMessage textarea').val()
            // console.log(message)
            if(message != ""){
                xhr.open('POST',url)
                form.append('idDisc',idDisc)
                form.append('message',message)
                form.append('destination',destination)
                xhr.send(form)
                
                xhr.onreadystatechange=function(){
                    if(xhr.readyState == 4 && xhr.status == 200){
                        console.log(xhr.responseText)
                        messageEnv = "<div class=\"message-env bg-success\">"+message+"</div>"
                        $('.messages').html($('.messages').html() + messageEnv)
                        $('.sendMessage textarea').val('')
                        let messagesContainer = $('.fenetre-messages')
                        messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
                        // console.log(xhr.responseText)
                    }
                }
            }
        })
    })
    // $('.sendMessage button').off('click').on('click',function(){
    //     let message = $('.sendMessage textarea').val()
    //     // console.log(message)
    //     if(message != ""){
    //         xhr.open('POST',url)
    //         form.append('idDisc',idDisc)
    //         form.append('message',message)
    //         form.append('destination',destination)
    //         xhr.send(form)
            
    //         xhr.onreadystatechange=function(){
    //             if(xhr.readyState == 4 && xhr.status == 200){
    //                 console.log(xhr.responseText)
    //                 messageEnv = "<div class=\"message-env bg-success\">"+message+"</div>"
    //                 $('.messages').html($('.messages').html() + messageEnv)
    //                 $('.sendMessage textarea').val('')
    //                 let messagesContainer = $('.fenetre-messages')
    //                 messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
    //                 // console.log(xhr.responseText)
    //             }
    //         }
    //     }
    // })
}
$(sendMessage)