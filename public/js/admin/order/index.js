const orderStatus = document.getElementById('status').dataset.show;

document.addEventListener('DOMContentLoaded', function() {
    if(orderStatus == 'pending'){
        document.querySelector('.pending').classList.add('active');
    }else if(orderStatus == 'shipped'){
        document.querySelector('.shipped').classList.add('active');
    }else if(orderStatus == 'canceled'){
        document.querySelector('.canceled').classList.add('active');
    }
});
