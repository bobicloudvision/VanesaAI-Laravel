<?php

namespace Tests\Browser;

use App\Robot\RobotTalk;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\SendMessageToUser;
use Tests\DuskTestCase;

class FacebookBotTest extends DuskTestCase
{

    // windows: C:\xamp-php81\php\php.exe artisan dusk --filter FacebookBot
    // schtasks /create /sc MINUTE /tn FacebookChatbot /tr C:\Users\bobkata\Games\VanesaAI-Laravel\vanesa-fb-bot.bat /ru system

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
            $browser->pause(1000);

            $browser->type('#email', env('FB_EMAIL'));
            $browser->type('#pass', env('FB_PASSWORD'));

            $browser->click('#loginbutton');
            $browser->pause(2000);



            $browser->pause(2000);
            $threadsCount = $browser->script("
            const nodes6 = document.getElementsByTagName(\"div\");
            let threadsI = 0;
            for (let i = 0; i < nodes6.length; i++) {
                if (nodes6[i].getAttribute('data-testid') == 'mwthreadlist-item') {
                     nodes6[i].classList.add('js-last-message-' + threadsI);
                    threadsI++;
                }
            }
            return threadsI;
            ")[0];
            $browser->pause(1000);

            for ($i = 0; $i <= $threadsCount; $i++) {

                $browser->click('.js-last-message-' . $i);
                $browser->pause(3000);

                // get last messages
                $countLastMessages = $browser->script("
              const nodesMes6 = document.getElementsByTagName(\"div\");
               let userSendedMessages = [];
                for (let i = 0; i < nodesMes6.length; i++) {
                  if (nodesMes6[i].getAttribute('data-scope') == 'messages_table') {

                        let userName = '';

                       const nodesMes6_Author = nodesMes6[i].getElementsByTagName(\"h4\");
                      if (nodesMes6_Author.length > 0) {
                            userName = nodesMes6_Author.innerText;
                            for (let imAuthor = 0; imAuthor < nodesMes6_Author.length; imAuthor++) {
                             userName = nodesMes6[i].getElementsByTagName(\"h4\")[imAuthor].innerText
                            }
                       }

                         const nodesMes6_AuthorSpan = nodesMes6[i].getElementsByTagName(\"span\");
                      if (nodesMes6_AuthorSpan.length > 0) {
                            userName = nodesMes6_AuthorSpan.innerText;
                            for (let imAuthorSpan = 0; imAuthorSpan < nodesMes6_AuthorSpan.length; imAuthorSpan++) {
                             userName = nodesMes6[i].getElementsByTagName(\"span\")[imAuthorSpan].innerText;
                             break;
                            }
                       }

                       if (userName) {
                            getMsgContainer = nodesMes6[i].getElementsByTagName(\"div\");
                            for (let imsg = 0; imsg < getMsgContainer.length; imsg++) {
                               if (getMsgContainer[imsg].getAttribute('data-testid') == 'message-container') {
                                    userSendedMessages.push({
                                        from: userName,
                                        msg: getMsgContainer[imsg].innerText
                                    });
                                }
                            }
                        }
                   }
                }
                return userSendedMessages;
                ")[0];

                $cleanedMessages = [];
                if (!empty($countLastMessages)) {
                    foreach ($countLastMessages as $message) {
                        if (empty($message['msg'])) {
                            continue;
                        }

                        $userName = $message['from'];
                        if ($message['from'] == 'Изпратихте') {
                            $message['from'] = 'me';
                            $userName = 'Robot';
                        } else {
                            $message['from'] = 'user';
                        }

                        $cleanedMessages[] = [
                            'message_username'=> $userName,
                            'message_from'=> $message['from'],
                            'message_text'=> $message['msg'],
                        ];
                    }
                }

                if (empty($cleanedMessages)) {
                    continue;
                }

                $lastMessage = end($cleanedMessages);
                if (isset($lastMessage['message_from']) && $lastMessage['message_from'] =='me') {
                    continue;
                }

                $lastMessageText = '';
                foreach ($cleanedMessages as $message) {
                    $lastMessageText = $message['message_text'];
                }

                $talk = new RobotTalk();
                $talk->setInput($lastMessageText);
                $robotResponse = $talk->getResponse();

                $browser->within(new SendMessageToUser(), function ($browser) use($robotResponse) {
                    $browser->sendMessage($robotResponse);
                });

            }

        });
    }
}
