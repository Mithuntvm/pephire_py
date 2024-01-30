# -*- coding: utf-8 -*-
"""
Created on Tue Oct 26 10:37:32 2021

@author: mithun

"""

import requests,json,pandas as pd, mysql.connector
from config import pephire_db
from flask import Flask, request
from Lib_v1 import db_read,db_write,logger
import os,pandas as pd
from config import pephire_db_trans,currDir,lang
os.chdir(currDir)
app = Flask(__name__)

@app.route('/cleartransdb', methods=['POST'])
def ClearDB_trans(): 
    try:
        print('clearcall')
        org_id =[]
        phone=[]
        jsonf = request.data
        jsonf=jsonf.decode("utf-8")
        data = json.loads(jsonf)
        print(data)
        org_id = data['organization_id']
        phone=data['phone']
        
        sQry = "select id from pephire.candidates where organization_id='"+str(org_id)+"' and phone='"+phone+"' "
        df_candidateid = db_read(sQry,pephire_db_trans,"select")
        candidateid=df_candidateid['id'].iloc[0]
        sQry=''
        sQry = "delete  from pephire_trans.candidate_stages_v2 where id ='"+str(candidateid)+"'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''
        if Flag !='1':
            logger('Delete from candidate_stages_v2 failed' , phone)
        sQry = "delete  from pephire_trans.conversation_details_v2 where candidatePhone ='"+phone+"'and organization_id='"+str(org_id)+"'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''
        if Flag !='1':
            logger('Delete from conversation details table failed' , phone)
        sQry = "delete  from pephire_trans.last_conversation_v2 where candidatePhone ='"+phone+"'and organization_id='"+str(org_id)+"'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''
        if Flag !='1':
            logger('Delete from last conversation table failed' , phone)
        sQry = "delete  from pephire_trans.link_verification_status where Phone ='"+phone+"'and oid='"+str(org_id)+"'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''
        if Flag !='1':
            logger('Delete from link verification status table failed' , phone)
        sQry = "delete  from pephire_trans.personalization_parameters_v2 where Phone ='"+phone+"'and oid='"+str(org_id)+"'"
        Flag = db_write(sQry,pephire_db_trans,"others")
        sQry = ''
        if Flag !='1':
            logger('Delete from personalization parameters table failed' , phone)
    except Exception as e:
        return e
            
    return 'success'

print('Ready to Serve')
from gevent.pywsgi import WSGIServer
http_server = WSGIServer(('127.0.0.1',9001), app)
http_server.serve_forever()