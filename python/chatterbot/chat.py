from chatterbot import ChatBot
from chatterbot.trainers import ChatterBotCorpusTrainer

chatbot = ChatBot('Vanesa', storage_adapter='chatterbot.storage.SQLStorageAdapter',
                           logic_adapters=[
                                {
                                   'import_path': 'chatterbot.logic.BestMatch',
                                   'default_response': '__robot_action_no_response__',
                                 'maximum_similarity_threshold': 0.96
                               },
                               {
                                    'import_path': 'chatterbot.logic.MathematicalEvaluation',
                               },
                              {
                                 'import_path': 'chatterbot.logic.UnitConversion',
                               }
                           ])

user_input = input()
bot_response = chatbot.get_response(user_input)
print(bot_response)
