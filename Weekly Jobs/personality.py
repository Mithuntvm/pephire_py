import re
from bs4 import BeautifulSoup
from string import punctuation
from nltk.corpus import stopwords
import joblib
from keras.models import load_model

mbti = {'I':'Introversion', 'E':'Extroversion', 'N':'Intuition', 
        'S':'Sensing', 'T':'Thinking', 'F': 'Feeling', 
        'J':'Judging', 'P': 'Perceiving'}

mbtpipe = joblib.load('data/tfidf_svd.pkl')

models ={y:load_model(f'data/{y}.h5') for y in ['IxE', 'NxS', 'FxT', 'PxJ']}

def cleanText(text):
    text = BeautifulSoup(text, "lxml").text
    text = re.sub(r'http\S+', r'<URL>', text)
    text = re.sub(r'\|\|\|', r' ', text) 
    return text

def mbtDesc(text):
    text = [cleanText(text)]
    data = mbtpipe.transform(text)
    traits = []
    for y in ['IxE', 'NxS', 'FxT', 'PxJ']:
        y_pred = models[y].predict_classes(data)
        traits.append(y[0] if y_pred==1 else y[-1])
        
    Type = ''.join(traits)
    return Type