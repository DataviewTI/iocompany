'use strict';
let mix = require('laravel-mix');

function IOCompany(params={}){
  let $ = this;
  this.dep = {
    service: 'node_modules/intranetone-company/src/',
    cropper: 'node_modules/cropperjs/dist/',
    jquerycropper: 'node_modules/jquery-cropper/dist/',
    dropzone: 'node_modules/dropzone/dist/',
    moment: 'node_modules/moment/',
  }

  let config = {
    optimize:false,
    sass:false,
    fe:true,
    cb:()=>{},
  }
  
  this.compile = (IO,callback = ()=>{})=>{

    mix.styles([
      IO.src.css + 'helpers/dv-buttons.css',
      IO.src.io.css + 'dropzone.css',
      IO.src.io.css + 'dropzone-preview-template.css',
      IO.src.io.vendors + 'aanjulena-bs-toggle-switch/aanjulena-bs-toggle-switch.css',
      IO.src.io.css + 'sortable.css',
      IO.dep.io.toastr + 'toastr.min.css',
      IO.src.io.css + 'toastr.css',
      $.dep.cropper + 'cropper.css',
      $.dep.service + 'company.css',
    ], IO.dest.io.root + 'services/io-company.min.css');
    
    mix.babel([
      IO.src.js + 'extensions/ext-jquery.js',
      IO.src.io.vendors + 'aanjulena-bs-toggle-switch/aanjulena-bs-toggle-switch.js',
      IO.dep.io.toastr + 'toastr.min.js',
      IO.src.io.js + 'defaults/def-toastr.js',
      $.dep.dropzone + 'dropzone.js',
      IO.src.io.js + 'dropzone-loader.js',
    ], IO.dest.io.root + 'services/io-company-babel.min.js');
    
    mix.scripts([
      IO.dep.jquery_mask+'jquery.mask.min.js',
      IO.src.js + 'extensions/ext-jquery.mask.js',
      $.dep.moment + 'min/moment.min.js',
      IO.src.io.vendors + 'moment/moment-pt-br.js',
      $.dep.cropper + 'cropper.js',
      $.dep.jquerycropper + 'jquery-cropper.js',
    ], IO.dest.io.root + 'services/io-company-mix.min.js');

    //copy separated for compatibility
    mix.babel($.dep.service + 'company.js', IO.dest.io.root + 'services/io-company.min.js');

    callback(IO);
  }
}


module.exports = IOCompany;
