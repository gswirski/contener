<?php

class Application_Cache_ServiceContainer extends Contener_ServiceContainer
{
  protected $shared = array();

  public function __construct()
  {
    parent::__construct($this->getDefaultParameters());
  }

  protected function getComponent_CreatorService()
  {
    if (isset($this->shared['component.creator'])) return $this->shared['component.creator'];

    $class = $this->getParameter('component.creator.class');
    $instance = new $class($this);

    return $this->shared['component.creator'] = $instance;
  }

  protected function getViewService()
  {
    if (isset($this->shared['view'])) return $this->shared['view'];

    $class = $this->getParameter('view.class');
    $instance = new $class($this->getService('view.loader'), $this->getParameter('view.renderers'), $this->getService('view.helper.set'));

    return $this->shared['view'] = $instance;
  }

  protected function getView_LoaderService()
  {
    if (isset($this->shared['view.loader'])) return $this->shared['view.loader'];

    $class = $this->getParameter('view.loader.class');
    $instance = new $class($this->getParameter('view.loader.paths'));

    return $this->shared['view.loader'] = $instance;
  }

  protected function getView_Helper_SetService()
  {
    if (isset($this->shared['view.helper.set'])) return $this->shared['view.helper.set'];

    $class = $this->getParameter('view.helper.set.class');
    $instance = new $class($this->getParameter('view.helper.set.list'));

    return $this->shared['view.helper.set'] = $instance;
  }

  protected function getView_Helper_JavascriptsService()
  {
    if (isset($this->shared['view.helper.javascripts'])) return $this->shared['view.helper.javascripts'];

    $class = $this->getParameter('view.helper.javascripts.class');
    $instance = new $class();

    return $this->shared['view.helper.javascripts'] = $instance;
  }

  protected function getView_Helper_StylesheetsService()
  {
    if (isset($this->shared['view.helper.stylesheets'])) return $this->shared['view.helper.stylesheets'];

    $class = $this->getParameter('view.helper.stylesheets.class');
    $instance = new $class();

    return $this->shared['view.helper.stylesheets'] = $instance;
  }

  protected function getView_Helper_AssetsService()
  {
    if (isset($this->shared['view.helper.assets'])) return $this->shared['view.helper.assets'];

    $class = $this->getParameter('view.helper.assets.class');
    $instance = new $class($this->getParameter('request.base_url'));

    return $this->shared['view.helper.assets'] = $instance;
  }

  protected function getView_Helper_UrlService()
  {
    if (isset($this->shared['view.helper.url'])) return $this->shared['view.helper.url'];

    $class = $this->getParameter('view.helper.url.class');
    $instance = new $class($this->getParameter('request.base_url'));

    return $this->shared['view.helper.url'] = $instance;
  }

  protected function getDefaultParameters()
  {
    return array(
      'loader.base_dir' => '/Users/sognat/Sites/Kontener/src/application/..',
      'database.dsn' => 'sqlite:/Users/sognat/Sites/Kontener/src/application/../application/database/database.db',
      'database.data_fixtures_path' => 'application/database/fixtures',
      'database.models_path' => 'framework/library',
      'database.yaml_schema_path' => 'application/database/schema',
      'database.generate_models_options' => array(
        'generateTableClasses' => true,
        'baseClassPrefix' => 'Base_',
        'classPrefix' => 'Contener_Database_Model_',
        'baseClassesDirectory' => '',
        'pearStyle' => true,
      ),
      'component.creator.class' => 'Contener_ComponentCreator',
      'view.class' => 'Contener_View',
      'view.loader.class' => 'sfTemplateLoaderFilesystem',
      'view.renderers' => array(

      ),
      'view.helper.set.class' => 'sfTemplateHelperSet',
      'view.helper.set.list' => array(
        0 => new sfServiceReference('view.helper.javascripts'),
        1 => new sfServiceReference('view.helper.stylesheets'),
        2 => new sfServiceReference('view.helper.assets'),
        3 => new sfServiceReference('view.helper.url'),
      ),
      'view.helper.javascripts.class' => 'sfTemplateHelperJavascripts',
      'view.helper.stylesheets.class' => 'sfTemplateHelperStylesheets',
      'view.helper.assets.class' => 'sfTemplateHelperAssets',
      'view.helper.url.class' => 'Contener_View_Helper_Url',
      'request.base_url' => '',
      'view.loader.paths' => '/Users/sognat/Sites/Kontener/src/framework/bundles/AdminBundle/Resources/template/%name%.php',
    );
  }
}
