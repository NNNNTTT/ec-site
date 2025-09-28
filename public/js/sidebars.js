/* global bootstrap: false */
(() => {
  'use strict'
  const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(tooltipTriggerEl => {
    new bootstrap.Tooltip(tooltipTriggerEl)
  })
})()

const show = document.getElementById('show').dataset.show;

if(show == 'order'){
    document.querySelector('[data-bs-target="#order-collapse"]').setAttribute('aria-expanded', 'true');
    document.querySelector('[data-bs-target="#order-collapse"]').classList.remove('collapsed');
    document.querySelector('#order-collapse').classList.add('show');
}else if(show == 'product'){
    document.querySelector('[data-bs-target="#product-collapse"]').setAttribute('aria-expanded', 'true');
    document.querySelector('[data-bs-target="#product-collapse"]').classList.remove('collapsed');
    document.querySelector('#product-collapse').classList.add('show');
}else if(show == 'sales' || show == 'sale'){
    document.querySelector('[data-bs-target="#sales-collapse"]').setAttribute('aria-expanded', 'true');
    document.querySelector('[data-bs-target="#sales-collapse"]').classList.remove('collapsed');
    document.querySelector('#sales-collapse').classList.add('show');
}

