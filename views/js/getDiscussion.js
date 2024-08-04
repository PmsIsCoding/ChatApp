let intervalID
function getDiscussion(){
    $('.discussion').click(function(){
        console.log('click')
        clearInterval(intervalID)
        let img = $('img',this).attr('src')
        $('.barre-photo').attr('src',img)
        $('.infos-discussion h1').html($('h2',this).html())
        $('.infos-discussion').fadeIn(500)
        $('.infos-discussion').css('display','flex')
        $('.sendMessage').addClass('d-flex')
        $('.sendMessage').removeClass('d-none')
        $('.messages').addClass('d-block')
        $('.messages').removeClass('d-none')
 
        let xhr = new XMLHttpRequest()
        let url = "../modeles/getMessages.php"
        let destination = $(this).attr('id')
        let idDisc = $(this).attr('value')
        let nbrMessages = 0
        
        var form = new FormData()
        form.append('destination',destination)
        form.append('idDisc',idDisc)
        form.append('option','nbrMessages')
        xhr.open('POST', url)
        xhr.send(form);  
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                nbrMessages = parseInt(xhr.responseText)
                console.log(nbrMessages)
            }
        };  

        let xhr2 = new XMLHttpRequest()
        var form = new FormData()        
        form.append('destination',destination)
        form.append('idDisc',idDisc)
        form.append('option','messages')

        xhr2.open('POST', url)
        xhr2.send(form);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
                $('.messages').html(xhr2.responseText)
                let messagesContainer = $('.fenetre-messages')
                messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
            }
        }; 

        intervalID = setInterval(function(){
            var form = new FormData() 
            let xhr3 = new XMLHttpRequest()
            let url = "../modeles/getMessages.php"
            form.append('destination',destination)
            form.append('idDisc',idDisc)
            form.append('option','nbrMessages')

            xhr3.open('POST', url)
            xhr3.send(form);
            xhr3.onreadystatechange = function() {
                if (xhr3.readyState == 4 && xhr3.status == 200) {
                    // console.log(parseInt(xhr3.responseText) > nbrMessages)
                    if(parseInt(xhr3.responseText) > nbrMessages){
                        // console.log("ok")
                        var form = new FormData() 
                        let xhr4 = new XMLHttpRequest()
                        let url = "../modeles/getMessages.php"
                        form.append('destination',destination)
                        form.append('idDisc',idDisc)
                        form.append('option','lastMessage')
                        xhr4.open('POST', url)
                        xhr4.send(form);  
                        // clearInterval(intervalID )
                        xhr4.onreadystatechange = function() {
                            if (xhr4.readyState == 4 && xhr4.status == 200) {
                                if(xhr.responseText != ""){
                                    $('.messages').html( $('.messages').html()+xhr4.responseText)
                                    let messagesContainer = $('.fenetre-messages')
                                    messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
                                    nbrMessages++

                                }
                                // let messagesContainer = $('.fenetre-messages')
                                // messagesContainer.scrollTop(messagesContainer.prop("scrollHeight"));
                            }
                        };   
                    }
                    // console.log("ok")
                }
            }
        },1000)           
    })
}

$(getDiscussion)