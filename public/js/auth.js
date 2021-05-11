$(document).ready(function() {

    let domen = 'http://test-quest.lara/';
    let bearer_token = localStorage['bearer_token'];
    let url_now = window.location.href;

    // =================
    // проверка актуальности Bearer token
    fetch(domen+'api/admin/access', {
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
        .then(data => data)
        .then( response => {
            // не авторизован
            if (response.status !== 200) {
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
        .catch(function (error) {});

// END
});
