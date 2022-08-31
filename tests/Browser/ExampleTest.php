<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {

            $siteUrl = 'https://www.messenger.com/login/';
            $browser->visit($siteUrl);
            $browser->pause(3000);
            $browser->script("
            const nodes5 = document.getElementsByTagName(\"button\");
            for (let i = 0; i < nodes5.length; i++) {
            nodes5[i].setAttribute('class', 'js-'+nodes5[i].getAttribute('data-testid'));
              console.log(nodes5[i]);
            }
            ");
            $browser->pause(3000);
            $browser->click('.js-cookie-policy-manage-dialog-accept-button');
            $browser->pause(5000);

            $browser->type('#email', '');
            $browser->type('#pass', '');

            $browser->click('#loginbutton');
            $browser->pause(5000);

            $browser->visit('https://www.messenger.com/t/');
            $browser->pause(3000);
            $browser->script("
          const nodes5 = document.getElementsByTagName(\"div\");
            for (let i = 0; i < nodes5.length; i++) {
						if (nodes5[i].getAttribute('aria-label') == 'Съобщение') {
           		 nodes5[i].classList.add('js-add-message');
              console.log(nodes5[i]);
            } else {
              console.log(nodes5[i].innerHTML);
            }
            }
            ");
            $browser->pause(3000);
            $browser->click('.js-add-message');
            $browser->pause(1000);
            $browser->type('.js-add-message', 'here is my message!');
            $browser->keys('.js-add-message', '{enter}');
            $browser->pause(3000);


        });
    }
}
