<?php
namespace sitawit\piwik;

use Yii;
use yii\base\Component;
use yii\web\View;
use yii\helpers\Html;
use yii\base\BootstrapInterface;
use yii\base\Application;

/**
 * The Piwik extension for Yii
 *
 * @author Sitawit Suteepohnwiroj <sitawit@gmail.com>
 */
class Piwik extends Component implements BootstrapInterface
{

    /**
     * Name of piwik variable.
     *
     * @var string
     */
    public $variableName = '_paq';

    /**
     * Site id which is generated by Piwik.
     *
     * @var integer
     */
    public $siteId;

    /**
     * Piwik tracker url.
     *
     * @var string
     */
    public $trackerUrl;

    /**
     * Enable no script rendering.
     *
     * @var boolean
     */
    public $enableNoScript = true;

    /**
     * Enable tracking.
     *
     * @var boolean
     */
    public $enable = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use($app) {
            $app->getView()
                ->on(View::EVENT_END_BODY, function () {
                $this->renderJs();
                $this->renderNoScript();
            });
        });
    }

    /**
     * Render tracking javascript.
     */
    protected function renderJs()
    {
        if ($this->enable === true) {
            $js = <<< JS
// Piwik Js
  var {$this->variableName} = {$this->variableName} || [];
  {$this->variableName}.push(['trackPageView']);
  {$this->variableName}.push(['enableLinkTracking']);
  (function() {
    var u="//{$this->trackerUrl}/";
    {$this->variableName}.push(['setTrackerUrl', u+'piwik.php']);
    {$this->variableName}.push(['setSiteId', {$this->siteId}]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
// End Piwik Js
JS;
            Yii::$app->view->registerJs($js, View::POS_END);
        }
    }

    /**
     * Render no script tracking pixel.
     */
    protected function renderNoScript()
    {
        if ($this->enable === true && $this->enableNoScript === true) {
            $html = <<< HTML
<!-- Piwik No Script -->
<noscript>
	<p>
		<img src="//{$this->trackerUrl}/piwik.php?idsite={$this->siteId}"
			style="border: 0;" alt="" />
	</p>
</noscript>     
<!-- End Piwik No Script -->       
HTML;
            echo $html;
        }
    }

    /**
     * Enable tracking.
     */
    public function enable()
    {
        $this->enable = true;
    }

    /**
     * Disable tracking.
     */
    public function disable()
    {
        $this->enable = false;
    }

    /**
     * Enable no script.
     */
    public function enableNoScript()
    {
        $this->enableNoScript = true;
    }

    /**
     * Disable no script.
     */
    public function disableNoScript()
    {
        $this->enableNoScript = false;
    }
}
