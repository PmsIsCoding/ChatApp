$(function(){
    let xhr2 = new XMLHttpRequest()
    $('.accepter').on('click',function(){
        let url = "../modeles/accepteDmd.php?loginEnv="+$(this).attr('id')
        console.log(url)
        xhr2.open('GET',url)
        xhr2.send()
        xhr2.onreadystatechange = function(){
            if(xhr2.readyState == 4 && xhr2.status == 200){
                console.log(xhr2.responseText)
            }
        }
    })
    function escapeSelector(selector) {
        return selector.replace(/([ #;?%&,.+*~\':"!^$[\]()=>|\/@])/g,'\\$1')
    }
    $('.accepter').on('click', function() {
        console.log('accepté')
        var userId = $(this).attr('id')
        var escapedUserId = escapeSelector(userId)
        $('.' + escapedUserId).fadeOut(100)

    });
})