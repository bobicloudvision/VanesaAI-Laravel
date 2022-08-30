import random
import json
import os
import torch
import sys

from model import NeuralNet
from nltk_utils import bag_of_words, tokenize

device = torch.device('cuda' if torch.cuda.is_available() else 'cpu')

chatbotFolder = sys.argv[1]
intentsFile = chatbotFolder + '/intents.json'
if os.path.exists(intentsFile):

    with open(intentsFile, 'r') as json_data:
        intents = json.load(json_data)

    FILE = chatbotFolder + "/brain.pth"

    if os.path.exists(FILE):

        data = torch.load(FILE)

        input_size = data["input_size"]
        hidden_size = data["hidden_size"]
        output_size = data["output_size"]
        all_words = data['all_words']
        tags = data['tags']
        model_state = data["model_state"]

        model = NeuralNet(input_size, hidden_size, output_size).to(device)
        model.load_state_dict(model_state)
        model.eval()

        sentence = input("")
        sentence = tokenize(sentence)
        #print(sentence)

        X = bag_of_words(sentence, all_words)
        X = X.reshape(1, X.shape[0])
        X = torch.from_numpy(X).to(device)

        output = model(X)
        _, predicted = torch.max(output, dim=1)

        tag = tags[predicted.item()]

        probs = torch.softmax(output, dim=1)
        prob = probs[0][predicted.item()]


        print(predicted.item())
        print(prob.item())

        if prob.item() > 0.94:
            for intent in intents['intents']:
                if tag == intent["tag"]:
                    print(random.choice(intent['responses']))
        else:
            print("__robot_action_no_response__")
    else:
        print("__robot_action_no_response__")
else:
    print("__robot_action_no_response__")
