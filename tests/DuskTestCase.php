<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $arguments = [];
        $arguments[] = '--disable-web-security';
        $arguments[] = '--disable-xss-auditor';
        //$arguments[] = '--enable-devtools-experiments';
        $arguments[] = '--disable-gpu';
        $arguments[] = '--no-sandbox';
        $arguments[] = '--ignore-certificate-errors';
        $arguments[] = '--window-size=1280,1080';
        $arguments[] = '--disable-popup-blocking';

        //  $arguments[] = '--headless';

        $options = (new ChromeOptions)->addArguments(collect($arguments)
            ->unless($this->hasHeadlessDisabled(), function ($items) use ($arguments) {
                if (getenv('GITHUB_RUN_NUMBER')) {
                    $arguments[] = '--headless';
                }
                return $items->merge($arguments);

            })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            ), 90000, 90000
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }

    /**
     * Determine if the browser window should start maximized.
     *
     * @return bool
     */
    protected function shouldStartMaximized()
    {
        return isset($_SERVER['DUSK_START_MAXIMIZED']) ||
               isset($_ENV['DUSK_START_MAXIMIZED']);
    }
}
