import json
from flask import Flask, request
import mysql.connector, pandas as pd
from datetime import datetime
import time

app = Flask(__name__)
app.config["DEBUG"] = True
@app.route('/DbOperations', methods=['POST'])        
def DbOperations():
    print('Call')
    jsonf = request.data
    data = json.loads(jsonf.decode("utf-8"))
    result = '0'
    for d in data:
        Query = d['Query']
        Database = d['Database'] 
        Type = d['Type']
    print(Query)
    mydb = mysql.connector.connect(**Database)
    mycursor = mydb.cursor()
    #There are three types of db operations: Select,Update,Delete and Insert. Select is the only query that is directly used with mydb and pd.read_sql. Update,Delete and Insert requires mycursor and a execute and commit flow.
    try:
        if Type == 'select':
            result = pd.read_sql(Query,mydb)
            mydb.close()
            print('select call at '+str(datetime.now()))
            return result.to_json(orient='records')
        else:
            mycursor.execute(Query)
            mydb.commit()
            result = '1'
            mydb.close()
            print('delete call at '+str(datetime.now()))
        return result  
    except:
        mydb.close()
        return ''
        



import os
from google.cloud.translate_v2 import client

os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = r"C:\Pephire\Whatsapp\pep.json"

translate_client = client.Client()
@app.route('/malayalam', methods=['POST'])  
def TranslateToMal():
    jsonf = request.data
    data = json.loads(jsonf.decode("utf-8"))
    for d in data:
        string = d['String']    
    print(string)
    output = translate_client.translate(string,target_language='en')
    return (output['translatedText'])


print('Ready to Serve')
from gevent.pywsgi import WSGIServer
http_server = WSGIServer(('0.0.0.0', 4005), app)
http_server.serve_forever()   
