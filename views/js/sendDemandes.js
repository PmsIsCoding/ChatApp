$(function(){
    let xhr = new XMLHttpRequest()
    $('.ajouter').on('click',function(){
        let loginTarget = $(this).attr('id')
        let target = '../modeles/gestDemande.php?loginTarget='+loginTarget
        xhr.open('GET',target)
        xhr.send()
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText)
            }
        }
    })

    function escapeSelector(selector) {
        return selector.replace(/([ #;?%&,.+*~\':"!^$[\]()=>|\/@])/g,'\\$1')
    }
    $('.ajouter').on('click', function() {
        var userId = $(this).attr('id')
        var escapedUserId = escapeSelector(userId)
        $('#' + escapedUserId).html("en attente")
        $('#'+escapedUserId).css({
            "width" : "auto",
            "border-radius" : "10px"
        })
    });
    
    // let xhr2 = new XMLHttpRequest()
    // $('.accepter').on('click',function(){
    //     let url = "accepteDmd.php?loginRec="+$(this).attr('value')+"&loginEnv="+$(this).attr('id')
    //     console.log(url)
    //     xhr2.open('GET',url)
    //     xhr2.send()
    //     xhr2.onreadystatechange = function(){
    //         if(xhr2.readyState == 4 && xhr2.status == 200){
    //             console.log(xhr2.responseText)
    //         }
    //     }
    // })
    // $('.accepter').on('click', function() {
    //     var userId = $(this).attr('id')
    //     var escapedUserId = escapeSelector(userId)
    //     $('.' + escapedUserId).fadeOut()
    // });
})