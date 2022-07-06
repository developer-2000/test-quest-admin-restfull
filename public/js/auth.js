$(document).ready(function() {
    var loc = window.location;
    let domen = loc.protocol+"//"+loc.hostname;
    let bearer_token = localStorage['bearer_token'];
    let url_now = window.location.href;

    // проверка актуальности Bearer token
    if(bearer_token === ''){
        checkBearerToken()
    }

    async function checkBearerToken(){
        await fetch(domen+'/api/admin/access', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "Authorization": bearer_token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({})
        })
            .then(data => data.json())
            .then( response => {
                // не авторизован
                if (!(typeof response.message === 'object')) {
                    // перадресация на авторизацию
                    if (url_now.indexOf('/auth') === -1) {
                        window.location.href = '/admin/auth';
                    }
                }
                // авторизован
                else{
                    // нахожусь на авторизации
                    if (url_now.indexOf('/auth') !== -1) {
                        window.location.href = '/admin';
                    }
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

});
