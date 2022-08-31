<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class SendMessageToUser extends BaseComponent
{

    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {

    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [];
    }

    public function sendMessage(Browser $browser, $message = 'hello')
    {
        // send message
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
        $browser->type('.js-add-message', $message);
        $browser->keys('.js-add-message', '{enter}');
        $browser->pause(3000);


    }

}
