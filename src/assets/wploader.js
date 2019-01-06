'use strict';
let mix = require('laravel-mix');

function IOCompany(params = {}) {
    let $ = this;
    this.dep = {
        service: 'node_modules/intranetone-company/src/',
        devbridgeAC: 'node_modules/devbridge-autocomplete/dist/',
        moment: 'node_modules/moment/',
    }

    let config = {
        optimize: false,
        sass: false,
        fe: true,
        cb: () => {},
    }

    this.compile = (IO, callback = () => {}) => {

        mix.styles([
            IO.src.io.root + 'custom/custom-devbridge.css',
            IO.src.io.vendors + 'aanjulena-bs-toggle-switch/aanjulena-bs-toggle-switch.css',
            IO.dep.io.toastr + 'toastr.min.css',
            IO.src.io.css + 'toastr.css',
            $.dep.service + 'company.css',
        ], IO.dest.io.root + 'services/io-company.min.css');

        mix.babel([
            IO.src.js + 'extensions/ext-jquery.js',
            IO.src.io.vendors + 'aanjulena-bs-toggle-switch/aanjulena-bs-toggle-switch.js',
        ], IO.dest.io.root + 'services/io-company-mix-babel.min.js');

        mix.scripts([
            IO.dep.jquery_mask + 'jquery.mask.min.js',
            IO.src.js + 'extensions/ext-jquery.mask.js',
            $.dep.moment + 'min/moment.min.js',
            IO.src.io.vendors + 'moment/moment-pt-br.js',
        ], IO.dest.io.root + 'services/io-company-mix.min.js');

        //copy separated for compatibility
        mix.babel($.dep.service + 'company.js', IO.dest.io.root + 'services/io-company.min.js');



        mix.copy($.dep.service + 'optimized_cbo.js', 'public/js/optimized_cbo.js');

        mix.styles([
            IO.src.io.root + 'custom/custom-devbridge.css',
            $.dep.service + 'job.css',
            IO.dep.io.toastr + 'toastr.min.css',
            IO.src.io.css + 'toastr.css',
        ], IO.dest.io.root + 'services/io-job.min.css');

        mix.babel([
            $.dep.devbridgeAC + 'jquery.autocomplete.min.js',
            IO.dep.io.toastr + 'toastr.min.js',
            IO.src.io.js + 'defaults/def-toastr.js',
            $.dep.service + 'job.js',
        ], IO.dest.io.root + 'services/io-jobs.min.js');

        mix.js([
            IO.dep.jquery_mask + 'jquery.mask.min.js',
            IO.src.js + 'extensions/ext-jquery.mask.js',
            $.dep.moment + 'moment.js',
            $.dep.service + 'candidate.js',
        ], IO.dest.io.root + 'services/io-candidates.min.js');


        callback(IO);
    }
}


module.exports = IOCompany;
