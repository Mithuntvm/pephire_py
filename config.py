# -*- coding: utf-8 -*-
"""
Created on Thu Feb  6 15:22:22 2020

@author: mithun
"""

#pephire_string = "host=127.0.0.1,user=root,passwd=password,database=pephire"
#pephire_static_string = "host=127.0.0.1,user=root,passwd=password,database=pephire_static"
#connectParams_pephire = dict(entry.split('=') for entry in pephire_string.split(','))
#connectParams_pephire_static = dict(entry.split('=') for entry in pephire_static_string.split(','))

# pephire_db = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire'}
# pephire_db_stat = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_static'}
# pephire_db_trans = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_trans'}
# engine_string = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire'
# engine_string_stat = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_static'



env='demo'
if env == 'demo':
   
    pephire_db = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire'}
    pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
    pephire_db_trans = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_trans'}
    engine_string = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com/pephire'
    engine_string_stat = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@1pepmysql.mysql.database.azure.com/pephire_static'
    
    RoleAliasQry = 'select * from pephire_static.rolealias'
    MainClusterQry = 'select * from pephire_static.maincluster'
    SkillNormQry = 'SELECT * FROM pephire_static.newskillnorm;'
    pephire='pephire'
    pephire_trans='pephire_trans'
    pephire_static='pephire_static'
    ImagePath  = 'E:\Pephire_resumes\storage\candidate_photos'
    RawImagePath = r"E:\Pephire_resumes\storage\candidate_photos"
else:
    pephire_db = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_test'}
    pephire_db_stat = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_static_test'}
    pephire_db_trans = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_trans'}
    engine_string = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_test'
    engine_string_stat = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_static_test'
    RoleAliasQry = 'select * from pephire_static_test.rolealias'
    MainClusterQry ='select * from pephire_static_test.maincluster'
    SkillNormQry = 'SELECT * FROM pephire_static_test.newskillnorm;'
    pephire='pephire_test'
    pephire_trans='pephire_trans_test'
    pephire_static='pephire_static_test'

#user – pephire@pepmysql

#Nopassword4you
# =============================================================================
# pephire_db = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire'}
# pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
# 
# engine_string = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com:3306/pephire'
# engine_string_stat = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com:3306/pephire_static'
# =============================================================================

#SkillNorm and MainCluster are switched in JDLibrariesv1.py based on the variable Domain.
#In Fitment_API_v6.py and RecommendingProfiles.py SkillNorm and Maincluster are imported from JDLibrariesv1.py
#Domain = 1 implies IT 
#Domain = 0 implies Retail
Domain = 1
#Whatsapp api endpoints
GetChatTexturl = 'http://127.0.0.1:40005/GetChatText'
SendChatTexturl = 'http://127.0.0.1:40005/SendChat'
GetStatusurl = 'http://127.0.0.1:40005/GetStatus'
GetContactStatusurl = 'http://127.0.0.1:40005/GetContactStatus'
DbOperationsurl = 'http://127.0.0.1:40005/DbOperations'
bPersonalityQnEnabled = True
bChatLogEnabled = True
bWhitelistEnabled = True

extractionDemoURL = 'http://20.219.163.20:5000/extraction'
#extractionDemoURL = 'https://extractiondemo.azurewebsites.net/api/extraction?code=fmLfafuzyoBKmPA6-jUxlbsG_-TgSRLjEEy0R4htoOMTAzFu-PKQKw=='
fitmentDemoURL = 'https://fitmentdemo.azurewebsites.net/api/fitment?code=OsF22D-8gkLuz7RwDr_0fhmuhJW7-mxd8Mfcs8xzIbX-AzFuEbgIxA=='
recommendationDemoURL = 'https://recommendationdemo.azurewebsites.net/api/Recommendation?code=T7np9ubbjEMb-j945tUuYpCHMVKeZJhyW7XmzfGknd0oAzFuyWpcvA=='