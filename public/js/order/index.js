// ストライプの処理
document.addEventListener('DOMContentLoaded', () => {
    const cardBtn = document.getElementById('card_btn');
    cardBtn.addEventListener('click', async () => {
        const response = await fetch(orderCardRoute, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        console.log('サーバーからのデータ:', data);
        console.log('成功:', data.success);

        if(data.success){
            const stripe = Stripe(stripePublicKey);

            const elements = stripe.elements();
            const style = {
                base: {
                    fontSize: '18px', 
                    lineHeight: '2',   
                    color: '#333',         
                    '::placeholder': {
                        color: '#aaa',
                    },
                },
                invalid: {
                    color: '#dc3545', 
                }
            };
            const cardNumber = elements.create('cardNumber', { style: style });
            cardNumber.mount('#card-number');
            const cardExpiry = elements.create('cardExpiry', { style: style });
            cardExpiry.mount('#card-expiry');
            const cardCvc = elements.create('cardCvc', { style: style });
            cardCvc.mount('#card-cvc');
    
            const clientSecret = data.client_secret;
    
            const cardSubmit = document.getElementById('card-submit');
            cardSubmit.addEventListener('click', async (e) => {
                e.preventDefault();
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret,
                    {
                        payment_method: {
                            card: cardNumber,
                        },
                    },
                );
    
                if (error) {
                    console.error(error);
                    document.getElementById('error-message').textContent = error.message;
                } else {
                    console.log('セットアップインテントが成功しました');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(orderCardRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ setup_intent_id: setupIntent.id }),
                    });
                    const data2 = await res.json();
                    console.log('サーバーからのデータ:', data2);

                    if(data2.success){
                        document.querySelector('input[name="customer_id"]').value = data2.customer_id;
                        document.querySelector('input[name="payment_method_id"]').value = data2.payment_method_id;
                        const btnClose = document.querySelector('.btn-close');
                        btnClose.click();
                        document.querySelector('.card-message').textContent = 'カードの登録が完了しました';
                        document.getElementById('card_btn').style.display = 'none';
                        document.getElementById('order_btn').disabled = false;
                    }else{
                        document.getElementById('error-message').textContent = data2.message;
                    }

                }
            });
        }else{
            document.getElementById('error-message').textContent = data.message;
        }
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(function(input){
        input.addEventListener('change', function(){
            if(this.value === 'credit_card'){
                document.getElementById('order_btn').disabled = true;
            } else {
                document.getElementById('order_btn').disabled = false;
            }
        });
    });


    $('#radio_card').click(function(){
        $('.card-btn').slideDown();
        $('.card-btn-title').slideDown();
    });

    $('#radio_cash_on_delivery').click(function(){
        $('.card-btn').slideUp();
        $('.card-btn-title').slideUp();
    });

    $('#radio_cash_on_delivery').click(function(){
        $('.card-btn').slideUp();
        $('.card-btn-title').slideUp();
    });
});