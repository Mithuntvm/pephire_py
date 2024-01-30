# -*- coding: utf-8 -*-
"""
Created on Mon Jul 25 14:10:49 2022

@author: mithun
"""
import os
from config import pephire_db_trans,currDir,pephire_trans
os.chdir(currDir)
from Lib_v1 import db_write,logger
import os
import json
from flask import Flask, request
from WhatsAppFunctions_v1 import SendChat
import datetime

import time


t = 1653457868

app = Flask(__name__)

@app.route('/parameters', methods=['POST'])
def whatsaappconv():
    #get the data from UI
    jsonf = request.data
    data = json.loads(jsonf) 
    f = open("UISend.txt", "w")
    f.write(str(data))
    f.close()
    #get the parameters
    sText = data['message']
    print(sText)
    sPhoneNumber = data['candidatePhone']
    print(sPhoneNumber)
    
    oid = data['oid']
    print(oid)
    uid = data['user_id']
    print(uid)
    sPhoneNumber=sPhoneNumber.replace(' ', '')
    sPhoneNumber=sPhoneNumber.replace('+', '')
    if len(sPhoneNumber)>10:
        sPhoneNumber=sPhoneNumber
    else :
        sPhoneNumber='91'+sPhoneNumber
    source ='web'
    #get the current time
    # currenttime = datetime.now()
    currenttime = datetime.datetime.now()
    print(currenttime)
    timestamp =int(time.mktime(datetime.datetime.now().timetuple()))
    print(timestamp)
    
    print("number"+sPhoneNumber)
    #send the message
    send =SendChat(sText,source,sPhoneNumber)
    if send=='success':
        sQry = "delete FROM "+pephire_trans+".last_conversation_v2 where candidatePhone = '" +sPhoneNumber + "' and message_source = 'WEB' and organization_id ='" + '1' + "'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        print("sucesss")
        sQry = ''
        sQry = """insert into """+pephire_trans+".conversation_timestamp values('"+str(sPhoneNumber)+"','"+str(oid)+"','"+str(timestamp)+"') """
        Flag = db_write(sQry,pephire_db_trans,"others")
        if Flag !='1':
            logger('Failed to insert into conversation_details_v2 table')
        print("sucesss")
        sQry = "insert into "+pephire_trans+".last_conversation_v2 values ('"+str(sPhoneNumber)+"','"+str(oid)+"','"+str(uid)+"','"+sText+"','Manual Chat','qnweb','','"+str(currenttime)+"','WEB')"     
        Flag = db_write(sQry,pephire_db_trans,"others")
        if Flag !='1':
            logger('Failed to insert into conversation_details_v2 table')
        sQry = "insert into "+pephire_trans+".conversation_details_v2 values ('"+str(sPhoneNumber)+"','"+str(oid)+"','"+str(uid)+"','"+sText+"','',' ',' ','"+str(currenttime)+"','qnweb',null,'WEB')"     
        Flag = db_write(sQry,pephire_db_trans,"others")
        if Flag !='1':
            logger('Failed to insert into conversation_details_v2 table')
        print("sucesss")
        #if send is success give the time of send to the db
        out = currenttime
        print("loop")
    else:
        out =send
    out =str(out)
    print(out)
    return out







#if __name__ == '__main__':
#    app.run('0.0.0.0',port=7001)
print('Ready to Serve')
from gevent.pywsgi import WSGIServer
http_server = WSGIServer(('127.0.0.1', 7001), app)
http_server.serve_forever()   