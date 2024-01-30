# -*- coding: utf-8 -*-
"""
Created on Thu Feb  6 15:22:22 2020

@author: mithun
"""
# =============================================================================
# pephire_db = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire'}
# pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
# pephire_db_trans = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_trans'}
# 
# engine_string = 'mysql+mysqlconnector://pephire@pepmysql:password@pepmysql.mysql.database.azure.com:3306/pephire'
# engine_string_stat = 'mysql+mysqlconnector://pephire@pepmysql:password@pepmysql.mysql.database.azure.com/pephire_static'
# 
# =============================================================================

currDir = "C:\Pephire\Whatsapp"
qnPersonalityDisabled = 'qn12'
qnPersonalityEnabled = 'qn8'
totalIntroQns = 3
env='demo'
if env == 'demo':
    # pephire_db = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire'}
    # pephire_db_stat = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_static'}
    # pephire_db_trans = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_trans'}
    pephire_db = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire'}
    pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
    pephire_db_trans = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_trans'}

    engine_string = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com/pephire'
    engine_string_stat = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@1pepmysql.mysql.database.azure.com/pephire_static'
    pephire='pephire'
    pephire_trans='pephire_trans'
    pephire_static='pephire_static'
    twilionumber ='19704997600'
else:
    pephire_db = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_test'}
    pephire_db_stat = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_static_test'}
    pephire_db_trans = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_trans_test'}
    engine_string = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_test'
    engine_string_stat = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_static_test'
    pephire='pephire_test'
    pephire_trans='pephire_trans_test'
    pephire_static='pephire_static_test'

# =============================================================================
# pephire_db = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire'}
# pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
# pephire_db_trans = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_trans'}
# 
# engine_string = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com:3306/pephire'
# =============================================================================
Domain=1

#URLs
#PepHire -1 
GetChatTexturl = 'http://127.0.0.1:4005/GetChatText'
SendChatTexturl = 'http://127.0.0.1:4005/SendChat'
GetStatusurl = 'http://127.0.0.1:4005/GetStatus'
GetContactStatusurl = 'http://127.0.0.1:4005/GetContactStatus'
DbOperationsurl = 'http://127.0.0.1:4005/DbOperations'
lang=""
Translateurl = 'http://127.0.0.1:4005/malayalam'
bPersonalityQnEnabled = True
bChatLogEnabled = True
bWhitelistEnabled = True
DBFlag=True
#Demo
# =============================================================================
# GetChatTexturl = 'http://52.187.163.88:4005/GetChatText'
# SendChatTexturl = 'http://52.187.163.88:4005/SendChat'
# GetStatusurl = 'http://52.187.163.88:4005/GetStatus'
# GetContactStatusurl = 'http://52.187.163.88:4005/GetContactStatus'
# DbOperationsurl = 'http://52.187.163.88:4005/DbOperations'
# =============================================================================

#Self
# =============================================================================
# GetChatTexturl = 'http://127.0.0.1:4005/GetChatText'
# SendChatTexturl = 'http://127.0.0.1:4005/SendChat'
# GetStatusurl = 'http://127.0.0.1:4005/GetStatus'
# GetContactStatusurl = 'http://127.0.0.1:4005/GetContactStatus'
# DbOperationsurl = 'http://127.0.0.1:4005/DbOperations'
# 
# =============================================================================
