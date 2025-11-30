document.addEventListener('DOMContentLoaded', function() {

    const filter = document.querySelector('select[name="filter"]');
    filter.addEventListener('change', function() {
        const value = this.value;
        if(value === 'arrival') {
            window.location.href = arrival_url;
        } else if(value === 'ranking') {
            window.location.href = ranking_url;
        }
    });
});