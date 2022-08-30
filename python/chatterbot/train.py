from chatterbot import ChatBot
from chatterbot.trainers import ChatterBotCorpusTrainer

chatbot = ChatBot('Vanesa')

# Create a new trainer for the chatbot
trainer = ChatterBotCorpusTrainer(chatbot)

maindir = os.path.dirname(os.path.abspath(__file__))

# Train the chatbot based on the english corpus
trainer.train(maindir + "/corpus/data/bulgarian")
