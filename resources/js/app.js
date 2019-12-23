/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    created() {
        Echo.private('Reservation')
            .listen('ReservedTickets', (ticket) => {
                var seats = (ticket.Ticket).split(' ');
                if (seats[0] == window.eventID) {
                    for (var i = 1; i < seats.length; i++) {
                        var Query = $('#app .content .main .wrapper #seat-map .seatCharts-row #' + seats[i]);
                        $('#app .content .main .wrapper .booking-details #selected-seats #cart-item-' + seats[i]).remove();
                        if (Query.hasClass('selected')) {
                            Query.removeClass("selected");
                            var chairsCount = parseInt($('#app .content .main .wrapper .booking-details h3 #counter').text());
                            var price = parseInt($('#app .content .main .wrapper .booking-details b #total').text())
                            $('#app .content .main .wrapper .booking-details h3 #counter').text(chairsCount - 1);
                            $('#app .content .main .wrapper .booking-details b #total').text(price - 100);
                        }

                        Query.removeClass("available");
                        Query.addClass("unavailable");
                        Query.css("pointer-events", "none");
                    }
                }
            });
    }
});
