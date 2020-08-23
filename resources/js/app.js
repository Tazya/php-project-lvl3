require('./bootstrap');

let App = {
    run: () => {
        App.Domain.initialize();
    }
};

App.Ajax = {
    post: (url, data = {}) => {
        data.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"').attr('content')};
        return axios.post(url, data);
    },

    get: (url, params = {}) => {
        data = {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"').attr('content')},
            params: params,
        };

        return axios.get(url, data);
    },
};

App.Domain = {
    containers: {
        pagintaionLink: '.pagination a',
    },
    currentPage: 1,

    initialize: () => {
        App.Domain.checkInit();
        App.Domain.showChecks();
    },

    checkInit: () => {
        let buttons = document.getElementsByClassName('domain-check-btn');
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', (e) => {
                let target = e.target;
                App.Ajax.post('/ajax/domain-checks', { domain_id: target.getAttribute('data-domain-id') })
                .then((response) => {
                    $.jGrowl("Success!");
                    App.Domain.showChecks();
                })
                .catch((error) => {
                    console.log(error.response);
                    $.jGrowl("Error! " + error.response.status + " " + error.response.statusText, { theme: 'jgrowl-fail' });
                });
            });
        }
    },

    showChecks: () => {
        let checksContainer = document.getElementById('domain-checks');
        let domainId = checksContainer.getAttribute('data-domain-id');

        App.Ajax.get('/ajax/domain-checks?page=' + App.Domain.currentPage, { domain_id: domainId })
        .then(function (response) {
            checksContainer.innerHTML = response.data;
            App.Domain.paginationInit();
        })
        .catch(function (error) {
            console.log(error);
        });
    },

    paginationInit: function() {
        $(this.containers.pagintaionLink).on('click', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            App.Domain.currentPage = page;
            App.Domain.showChecks();
        });
    },

    checksPreloader: {
        spinner: `
        <div class="spinner__wrapper">
            <div class="spinner"></div>
        </div>
        `,

        show: function(selector) {
            $(selector).css('position', 'relative');
            $(selector).fadeIn(300, function() {
                $(this).prepend(App.Domain.checksPreloader.spinner);
            });
        },
        hide: function(selector) {
            $(selector).find('.spinner__wrapper').fadeOut(300, function() {
                $(this).remove()
            });
        },
    }
};

document.addEventListener("DOMContentLoaded", () => {
    App.run();
});
