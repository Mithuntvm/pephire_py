# -*- coding: utf-8 -*-
"""
Created on Tue Apr  6 16:35:38 2021

@author: mithun
"""
from config import pephire_db
DbOperationsurl = 'http://127.0.0.1:4005/DbOperations'
import requests
import json
import time
sQry = """delete from pephire.sessions where id in (select id from(SELECT id  FROM pephire.sessions where MINUTE(timediff(CURRENT_TIMESTAMP(),from_unixtime(last_activity)))>3) as c);"""
delQry = [{"Query":sQry,"Database":pephire_db,"Type":"delete"}] 
while True:
    DelFlag = requests.post(DbOperationsurl, json.dumps(delQry)).text
    print('Sleeping')
    time.sleep(300)
