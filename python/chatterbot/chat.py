from chatterbot import ChatBot
from chatterbot.trainers import ChatterBotCorpusTrainer

chatbot = ChatBot('Vanesa')

user_input = input()
bot_response = chatbot.get_response(user_input)
print(bot_response)
