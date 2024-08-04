$(function(){
    let previewNode = $('.discussions').html()
    setInterval(function(){
        let xhr = new XMLHttpRequest()
        xhr.open("GET","../modeles/gestFilDiscussion.php")  
        xhr.send()
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                if(previewNode != xhr.responseText){
                    $('.fenetre-discussion').html(xhr.responseText)
                    getDiscussion()
                    sendMessage()
                    previewNode = xhr.responseText
                }
                // console.log(xhr.responseText)
            }
        }
    },1000)
})