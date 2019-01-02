<?php
namespace Dataview\IOCompany;

use Illuminate\Support\ServiceProvider;

class IOCompanyServiceProvider extends ServiceProvider
{
  public static function pkgAddr($addr){
    return __DIR__.'/'.$addr;
  }

  public function boot(){
    $this->loadViewsFrom(__DIR__.'/views', 'Company');
    $this->loadViewsFrom(__DIR__.'/views/candidates', 'Candidate');
    $this->loadViewsFrom(__DIR__.'/views/jobs', 'Job');
  }

  public function register(){
    
    $this->commands([
      Console\Install::class,
      Console\Remove::class
    ]);

    $this->app['router']->group(['namespace' => 'dataview\iocompany'], function () {
      include __DIR__.'/routes/web.php';
    });

    $this->app['router']->aliasMiddleware('company_auth', '\Dataview\IOCompany\Http\Middleware\CompanySentinelAuth');
  
    $this->app->make('Dataview\IOCompany\CompanyController');
    $this->app->make('Dataview\IOCompany\CandidateController');
    $this->app->make('Dataview\IOCompany\JobController');
    $this->app->make('Dataview\IOCompany\CompanyRequest');
    $this->app->make('Dataview\IOCompany\CandidateRequest');
    $this->app->make('Dataview\IOCompany\JobRequest');
  }
}
