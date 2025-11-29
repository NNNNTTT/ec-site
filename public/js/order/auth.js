$(document).ready(function(){
    $('.login-tab').click(function(){
        $('.login-form').slideToggle();
        $('.register-form').slideUp();
    });
    $('.register-tab').click(function(){
        $('.register-form').slideToggle();
        $('.login-form').slideUp();
    });

    if($authTab === 'register'){
        $('.register-tab').prop('checked', true);
        $('.register-form').show();
        $('.login-form').hide();
    }
    
});

/* 郵便番号検索 */
document.querySelector('.postal_code_btn').addEventListener('click', function(){
    const postal_code_1 = document.querySelector('#postal_code_1').value;
    const postal_code_2 = document.querySelector('#postal_code_2').value;
    const postal_code = postal_code_1 + postal_code_2;
    
    fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postal_code}`)
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.status === 200){
            console.log(data.results[0].prefcode);
            document.querySelector('#prefecture').value = data.results[0].prefcode;
            document.querySelector('#address').value = data.results[0].address2 + data.results[0].address3;
        }else{
            document.querySelector('#error-message').textContent = '郵便番号が見つかりません';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});