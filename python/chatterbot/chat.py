from chatterbot import ChatBot
from chatterbot.trainers import ChatterBotCorpusTrainer

chatbot = ChatBot('Vanesa', language='RUS')

# Get a response to an input statement
while True:
    try:
        user_input = input()

        print(user_input)
        bot_response = chatbot.get_response(user_input)

        print(bot_response)

    # Press ctrl-d on the keyboard to exit
    except (KeyboardInterrupt, EOFError, SystemExit):
        break
