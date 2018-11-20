
# PJ Company - Palm Job Company Profiles
Serviço para cadastro das empresas do projeto PalmJob
## Conteúdo
 
## Instalação

```sh
composer require dataview/iocompany
```
```sh
php artisan io-company:install
```

- Configure o webpack conforme abaixo 
```js
...
let company = require('intranetone-company');
io.compile({
  services:[
    ...
    new company(),
    ...
  ]
});

```
- Compile os assets e faça o cache
```sh
npm run dev|prod|watch
php artisan config:cache
```
